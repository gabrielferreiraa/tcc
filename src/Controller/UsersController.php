<?php
namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController
{
    public function initialize() {
        parent::initialize();

        $this->Auth->allow('registerContractor');
        $this->Auth->allow('registerFreelancer');
    }

    public function registerContractor(){
        $this->render('contractor');
    }

    public function registerFreelancer(){
        $this->render('freelancer');
    }

    public function _saveUser($type){

    }
}
