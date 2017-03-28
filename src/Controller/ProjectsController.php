<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;


class ProjectsController extends AppController
{
    public $paginate = ['limit' => 5];

    public function initialize()
    {
        parent::initialize();
        $this->Skills = TableRegistry::get('Skills');
        $this->Users = TableRegistry::get('Users');
    }

    public function index()
    {
        $data = $this->request->query;

        $projects = $this->Projects->find()->where(['status' => 1]);

        if (!empty($data['project-name'])) {
            $projects->where([
                "title LIKE '%" . $data['project-name'] . "%'"
            ]);
        }

        if ($projects->count()) {
            $projects
                ->select($this->Projects)
                ->select([
                    'users_intersted' => 'COUNT(pui.id)'
                ])
                ->leftJoin(['pui' => 'project_users_intersted'], ['pui.project_id = Projects.id'])
                ->group('Projects.id');
        }

        $projects = $this->paginate($projects);

        $regions = [
            'centro-oeste' => 'Centro-Oeste',
            'nordeste' => 'Nordeste',
            'norte' => 'Norte',
            'sul' => 'Sul',
            'sudeste' => 'Sudeste'
        ];

        $skillsLimited = $this->Skills->find('list')->order('RAND()')->limit(8);
        $skills = $this->Skills->find('list');

        if ($skillsLimited->count()) {
            $skills->where([
                'id NOT IN' => array_keys($skillsLimited->toArray())
            ]);
        }

        $this->set(compact('projects', 'regions', 'skills', 'skillsLimited'));
        $this->set('_serialize', ['projects', 'regions', 'skills', 'skillsLimited']);
    }

    public function view()
    {
        if ($this->request->session()->read('Auth.User.type') == 'c') {
            $projects = $this->Projects->find()
                ->where([
                    'user_id' => $this->request->session()->read('Auth.User.id')
                ]);
        } else {
            $projects = $this->Projects->find()
                ->select($this->Projects)
                ->innerJoin(['puf' => 'project_users_fixed'], ['puf.project_id = Projects.id'])
                ->where([
                    'puf.user_id' => $this->request->session()->read('Auth.User.id')
                ]);
        }

        $this->set(compact('projects'));
        $this->set('_serialize', ['projects']);
    }

    public function add()
    {
        $project = $this->Projects->newEntity();
        if ($this->request->is('post')) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project could not be saved. Please, try again.'));
        }
        $this->set(compact('project'));
        $this->set('_serialize', ['project']);
    }

    public function edit($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
//            debug($project);exit;
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project could not be saved. Please, try again.'));
        }
        $this->set(compact('project'));
        $this->set('_serialize', ['project']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $project = $this->Projects->get($id);
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The project has been deleted.'));
        } else {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function details($id)
    {
        $project = $this->Projects->get($id, ['contain' => ['Users', 'ProjectFiles']]);

        $finishedProjects = $this->Users->getFinishedProjects($project->user->id);

        $this->set(compact('project', 'finishedProjects'));
    }
}
