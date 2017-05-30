<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

class SkillsController extends AppController
{
    public function index () {
        $this->viewBuilder()->layout(false);
    }
}
