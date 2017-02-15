<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * Token component
 */
class TokenComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function secure($min, $max) {
        $range = $max - $min;
        if ($range < 1)
            return $min;
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1;
        $bits = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public function generate($length) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->secure(0, $max)];
        }
        return $token;
    }

    public function validate() {
        $token = $this->getToken();
        if ($token) {
            $now = Time::now();
            $now->modify('-60 days');

            $adminTokens = TableRegistry::get('AdminTokens');

            $userToken = $adminTokens->find()
                    ->where([
                        'token' => $token,
                        'created >=' => $now->i18nFormat('yyyy-MM-dd HH:mm:ss')
                    ])
                    ->first();

            if ($userToken) {
                return true;
            } else {
                return false;
            }
            exit;
        }
    }

    public function getToken() {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            return $headers['Authorization'];
        } else {
            return false;
        }
    }

    public function getUser() {
        $token = $this->getToken();
        $admins = TableRegistry::get('Admins');
        $user = $admins->find()
                ->join(
                        ['at' => [
                                'table' => 'admin_tokens',
                                'type' => 'INNER',
                                'conditions' => 'at.admin_id = admins.id'
                            ]]
                )
                ->where(['at.token' => $token])
                ->first()
                ->toArray();

        return $user;
    }

}
