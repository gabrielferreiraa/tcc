<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\ORM\TableRegistry;

class SkillsController extends AppController
{
    public function index()
    {
        $this->viewBuilder()->layout('skills');
    }

    public function getSkills()
    {
        $this->Skills = TableRegistry::get('Skills');

        if ($this->request->is('post')) {
            $skills = $this->Skills->find()->hydrate(false);

            $result = ['status' => 'success', 'data' => $skills->toArray()];
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }

    public function filterSkills()
    {
        $this->Skills = TableRegistry::get('Skills');

        if ($this->request->is('post')) {
            $data = $this->request->data;

            $skills = $this->Skills->find()
                ->where([
                    "name like '%" . $data['likeName'] . "%'"
                ]);

            if ($skills->count()) {
                $skills = $skills->toArray();
            } else {
                $skills = [];
            }

            $result = ['status' => 'success', 'data' => $skills];
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }
}
