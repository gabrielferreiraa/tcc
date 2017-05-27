<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class HomeController extends AppController
{
    public function initialize() {
        parent::initialize();

        $this->Auth->allow('login');
        $this->Auth->allow('signIn');
        $this->Auth->allow('index');
    }

    public function index()
    {
        $this->viewBuilder()->layout('out');
    }

    public function login()
    {
        $this->viewBuilder()->layout('out');
    }

    public function signIn(){
        $result = ['type' => 'error'];
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $user = $this->Auth->identify($data);

            if ($user) {
                $result = [
                    'status' => 'success',
                    'title' => 'Bem vindo(a), ' . $user['name'],
                ];
                 
                $User = TableRegistry::get('Users');
                $User->changeStatusUser($this->request->session()->read('Auth.User.id'), 1);

                $this->Auth->setUser($user);
            } else {
                $result = [
                    'status' => 'error',
                    'title' => 'Usuário ou senha incorretos'
                ];
            }
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }

    public function signOut() {
        $User = TableRegistry::get('Users');
        $User->changeStatusUser($this->request->session()->read('Auth.User.id'), 0);

        return $this->redirect($this->Auth->logout());
    }
}
