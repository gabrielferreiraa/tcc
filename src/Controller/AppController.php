<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;

class AppController extends Controller
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Token');
        $this->loadComponent('PremioIdeal');

        parent::initialize();
        Configure::write('App.jsBaseUrl', '/');
        Configure::write('App.cssBaseUrl', '/');


        $this->loadComponent('File');
        $this->loadComponent('Util');
        $this->loadComponent('Flash');
        $this->loadComponent('RequestHandler');

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
                    'finder' => 'auth',
                    'userModel' => 'Users'
                ],
            ],
            'storage' => 'Session'
        ]);
        $this->Auth->sessionKey = 'Auth.Participant';
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public
    function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}
