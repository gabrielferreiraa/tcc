<?php
namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow('registerContractor');
        $this->Auth->allow('registerFreelancer');
        $this->Auth->allow('add');
        $this->Auth->allow('saveUser');
    }

    public function registerContractor()
    {
        $this->viewBuilder()->layout('out');
        $this->render('contractor');
    }

    public function registerFreelancer()
    {
        $this->viewBuilder()->layout('out');
        $this->render('freelancer');
    }

    public function add($base64)
    {
        $this->viewBuilder()->layout('out');
        list($type, $email) = explode('#', base64_decode($base64));
        $typeText = $this->Users->getTypeUser($type);

        $this->set(compact('email', 'type', 'typeText'));
        $this->set('_serialize', ['email', 'type', 'typeText']);
    }

    public function saveUser()
    {
        $result = ['status' => 'error', 'text' => 'Não foi possível realizar o cadastro'];
        if($this->request->is('post')){
            $data = $this->request->data;
            if($this->Users->isValidEmail($data['email'], $this->Users->getTypeUser($data['type'], true))){
                $user = $this->Users->newEntity();
                $user = $this->Users->patchEntity($user, $data);
                $user->type = $this->Users->getTypeUser($data['type'], true);
                $user->created_at = date('Y-m-d');
                if($this->Users->save($user)){
                    $userName = explode(' ', $user->name);
                    $result = ['status' => 'success', 'text' => 'Seja bem vindo(a) ' . $userName[0]];
                    $this->Auth->setUser($user);
                } else {
                    $result = ['status' => 'error', 'text' => 'Não foi possível realizar o cadastro'];
                }
            } else {
                $result = ['status' => 'error', 'text' => 'Já temos um ' . $this->Users->getTypeUser($data['type']) . ' com este e-mail'];
            }
        }
        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }

    public function view(){
        $user = $this->Users->find()
            ->hydrate(false)
            ->where([
                'email' => $this->request->session()->read('Auth.User.email')
            ])
            ->first();

        $null = 0;
        $complete = 0;
        foreach($user as $field){
            if(is_null($field)){
                $null++;
            } else {
                $complete++;
            }
        }

        $projectsUser = [];
        $skillsUser = [];
        $percentageProfile = ($complete/$null)*100;
        $this->set('skills', $skillsUser);
        $this->set('projectsUser', $projectsUser);
        $this->set('percentageProfile', round($percentageProfile));
        $this->render('profile');
    }

    public function edit(){

    }
}