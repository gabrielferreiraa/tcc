<?php
namespace App\Controller;

use App\Controller\AppController;

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

    }

    public function login()
    {
        $this->viewBuilder()->layout(false);
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
}
