<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class AppController extends Controller
{
    public function initialize()
    {
        parent::initialize();

        date_default_timezone_set('America/Sao_Paulo');

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Token');
        $this->loadComponent('Util');

        Configure::write('App.jsBaseUrl', '/');
        Configure::write('App.cssBaseUrl', '/');

        $this->Users = TableRegistry::get('Users');

        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => 'Home',
                'action' => 'login'
            ],
            'logoutRedirect' => [
                'controller' => 'Home',
                'action' => 'index'
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Home',
                'action' => 'login'
            ],
            'authenticate' => [
                'Form' => [
                    'passwordHasher' => [
                        'className' => 'Sha512',
                    ],
                    'fields' => ['username' => 'email'],
                    'userModel' => 'Users'
                ],
            ],
            'storage' => 'Session'
        ]);
        $this->Auth->sessionKey = 'Auth.User';
        if ($this->request->session()->read('Auth.User')) {
            $Messages = TableRegistry::get('Messages');
            $Users = TableRegistry::get('Users');

            $userBD = $Users->get($this->request->session()->read('Auth.User.id'));

            $lastMessageId = $Messages->find()
                ->select('id')
                ->where([
                    'to_user' => $userBD->id,
                ])
                ->orWhere([
                    'from_user' => $userBD->id
                ])
                ->order('id DESC')
                ->first();

            $userPicture = empty($userBD->picture) ? $this->request->webroot . '/front/img/user-default.png' : $userBD->picture;
            $userName = $this->request->session()->read('Auth.User.name');
            $userType = $this->Users->getTypeUser($this->request->session()->read('Auth.User.type'));

            $this->set('lastMessageId', empty($lastMessageId) ? '' : $lastMessageId->id);
            $this->set(compact('userPicture', 'userName', 'userType'));
            $this->set('_serialize', ['userPicture', 'userName', 'userType']);
        }
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}
