<?php
namespace App\Controller;

use App\Controller\AppController;

class HomeController extends AppController
{
    public function initialize() {
        parent::initialize();

        $this->Auth->allow('login');
    }

    public function index()
    {

    }

    public function login()
    {
        $this->viewBuilder()->layout(false);
    }
}
