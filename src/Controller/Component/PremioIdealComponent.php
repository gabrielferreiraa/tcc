<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Utility\Xml;
use Cake\Log\Log;

/**
 * PremioIdeal component
 */
class PremioIdealComponent extends Component {

    /**
     * Gera o link de login do Premio Ideal
     * @param  integer $participantID Id do participante
     * @return string   URL
     */
    public function getPremioIdeialLink($cpf, $catalog_pi) {

        $configIdeall = Configure::read('Campaign.premioideall');

        if (empty($cpf) || empty($catalog_pi))
            return '#';
        return $configIdeall['url'] . $configIdeall['login'] . '?cpf=' . base64_encode($cpf) . '&campanha=' . base64_encode($catalog_pi) . '';
    }

    public function updatePremioIdeall($participant) {

        $configIdeall = Configure::read('Campaign.premioideall');

        if (empty($configIdeall)) {
            return true;
        } else {
            $url = $configIdeall['url'] . $configIdeall['singlesignon'];

            if ($participant) {

                $name = explode(' ', $participant->name);
                $regex_result = [];
                //Home phone
                preg_match('/^\((.*)\)/s', $participant->home_phone, $regex_result);
                $phone['ddd'] = isset($regex_result[1]) ? $regex_result[1] : '';
                preg_match('/[\s\t](.*)/s', $participant->home_phone, $regex_result);
                $phone['phone'] = isset($regex_result[1]) ? $regex_result[1] : '';
                //Cell phone
                preg_match('/^\((.*)\)/s', $participant->cell_phone, $regex_result);
                $cell_phone['ddd'] = isset($regex_result[1]) ? $regex_result[1] : '';
                preg_match('/[\s\t](.*)/s', $participant->cell_phone, $regex_result);
                $cell_phone['phone'] = isset($regex_result[1]) ? $regex_result[1] : '';

                if (empty($phone['ddd'])) {
                    $phone['ddd'] = $cell_phone['ddd'];
                    $phone['phone'] = $cell_phone['phone'];
                }

                $first_name = '';
                $last_name = '';
                if (count($name) > 1) {
                    $last_name = $name[count($name) - 1];
                    unset($name[count($name) - 1]);
                }
                $first_name = implode(' ', $name);

                $data = array(
                    'FirstName' => $first_name,
                    'LastName' => $last_name,
                    'Address' => $participant->participant_addresses[0]->street ? $participant->participant_addresses[0]->street : '',
                    'Number' => $participant->participant_addresses[0]->number ? $participant->participant_addresses[0]->number : '',
                    'Complement' => $participant->participant_addresses[0]->complement ? $participant->participant_addresses[0]->complement : '',
                    'CityRegion' => $participant->participant_addresses[0]->district ? $participant->participant_addresses[0]->district : '',
                    'City' => $participant->participant_addresses[0]->city ? $participant->participant_addresses[0]->city->name : '',
                    'State' => $participant->participant_addresses[0]->city ? $participant->participant_addresses[0]->city->state->state_code : '',
                    'ZipCode' => $participant->participant_addresses[0]->zip_code ? $participant->participant_addresses[0]->zip_code : '',
                    'Phone' => $phone['phone'],
                    'DDD' => $phone['ddd'],
                    'Email' => $participant->email ? $participant->email : '',
                    'CPF' => $participant->cpf ? $participant->cpf : '',
                    'Birthday' => $participant->birth_date ? $participant->birth_date->i18nFormat('yyyy-MM-dd') : '',
                    'DDDCel' => $cell_phone['ddd'],
                    'Cel' => $cell_phone['phone'],
                    'sexo' => $participant->gender
                );

                $result = $this->CallAPI('POST', $url, $data);

                if (isset($configIdeall['log']) && $configIdeall['log']) {
                    try {
                        $result = Xml::toArray(Xml::build($result));
                        $error = $result['string'];
                    } catch (\Cake\Utility\Exception\XmlException $ex) {
                        $error = $result;
                    }

                    if (!empty($error)) {
                        $error = $participant->cpf . ': ' . $error;
                        Log::config('ideall', [
                            'className' => 'File',
                            'path' => LOGS,
                            'levels' => [],
                            'scopes' => ['ideall'],
                            'file' => 'ideall.log',
                        ]);

                        Log::warning($error, ['scope' => ['ideall']]);
                    }
                }


                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function getPoints($participant, $idCatalog) {
        $configIdeall = Configure::read('Campaign.premioideall');
        if ($participant) {
            $url = $configIdeall['url'] . $configIdeall['points'];
            $result = $this->CallAPI('POST', $url, ['cpf' => $participant['cpf'], 'campanha' => $idCatalog]);

            try {
                $result = Xml::toArray(Xml::build($result));
                if (isset($result['decimal'])) {
                    return $result['decimal'];
                } else {
                    return 0.00;
                }
            } catch (\Cake\Utility\Exception\XmlException $ex) {
                return 0.00;
            }

        } else {
            return false;
        }
    }

    /**
     * @param $method string POST, PUT, GET
     * @param $url
     * @param array $data array("param" => "value") ==> index.php?param=value
     * @return mixed
     * @throws Exception
     */
    public function CallAPI($method, $url, $data = array()) {
        if (!function_exists('curl_version')) {
            throw new Exception('cURL not found.');
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        $post_array_string = '';
        //url-ify the data
        foreach ($data as $key => $value) {
            $post_array_string .= $key . '=' . $value . '&';
        }
        $post_array_string = rtrim($post_array_string, '&');
        curl_setopt($curl, CURLOPT_POST, count($data));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_array_string);

        return curl_exec($curl);
    }

}
