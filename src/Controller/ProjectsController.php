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
        $this->ProjectUsersFixed = TableRegistry::get('ProjectUsersFixed');
        $this->ProjectUsersIntersted = TableRegistry::get('ProjectUsersIntersted');
        $this->UserReputations = TableRegistry::get('UserReputations');
    }

    public function index()
    {
        $data = $this->request->query;

        $projects = $this->Projects->find()
            ->contain(['Users'])
            ->where([
                'status' => 0
            ]);

        if (!empty($data['project-name'])) {
            $projects->where([
                "Projects.title LIKE '%" . $data['project-name'] . "%'",
                'OR' => [
                    "Projects.description LIKE '%" . $data['project-name'] . "%'"
                ]
            ]);
        }

        if (!empty($data['skills'])) {
            $projects
                ->leftJoin(['ps' => 'project_skills'], ['ps.project_id = Projects.id'])
                ->leftJoin(['s' => 'skills'], ['s.id = ps.skill_id'])
                ->where([
                    's.name IN' => $data['skills']
                ]);
        }

        if (!empty($data['budget'])) {
            $projects->where([$data['budget']]);
        }

        if ($projects->count()) {
            $userId = $this->request->session()->read('Auth.User.id');
            $caseIntersted = '(CASE WHEN pui.user_id = ' . $userId . ' THEN 1 ELSE 0 END)';
            $projects
                ->select($this->Projects)
                ->select([
                    'users_intersted' => 'COUNT(pui.id)',
                    'alreadyIntersted' => $caseIntersted
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
        $caseFinishedProjects = "(CASE WHEN Projects.date_end < CURDATE() THEN '1' ELSE '0' END)";

        if ($this->request->session()->read('Auth.User.type') == 'c') {
            $projects = $this->Projects->find()
                ->contain([
                    'ProjectSkills.Skills',
                    'ProjectFiles',
                    'ProjectUsersIntersted.Users',
                    'ProjectUsersFixed.Users',
                    'ProjectSteps',
                    'UserReputations'
                ])
                ->select($this->Projects)
                ->select([
                    'late' => $caseFinishedProjects
                ])
                ->innerJoin(['u' => 'users'], ['u.id = Projects.user_id'])
                ->where([
                    'Projects.user_id' => $this->request->session()->read('Auth.User.id')
                ]);

        } else {
            $projects = $this->Projects->find()
                ->contain([
                    'ProjectSkills.Skills',
                    'ProjectSteps',
                    'UserReputations'
                ])
                ->select($this->Projects)
                ->select([
                    'contractor' => 'u.name',
                    'late' => $caseFinishedProjects
                ])
                ->innerJoin(['u' => 'users'], ['u.id = Projects.user_id'])
                ->innerJoin(['puf' => 'project_users_fixed'], ['puf.project_id = Projects.id'])
                ->where([
                    'puf.user_id' => $this->request->session()->read('Auth.User.id')
                ]);
        }

        if ($projects->count()) {
            $projects = $projects->toArray();
        } else {
            $projects = [];
        }

        if (count($projects)) {
            foreach ($projects as $key => $project):
                $projects[$key]->status = [
                    'id' => $project->status,
                    'content' => $this->Projects->getStatus($project->status)
                ];
            endforeach;
        }

        if ($this->request->session()->read('Auth.User.type') == 'c') {
            foreach ($projects as $key => $project):
                if (count($project['project_users_intersted'])) {
                    foreach ($project['project_users_intersted'] as $keyUser => $user) {
                        $projects[$key]->project_users_intersted[$keyUser]->user->reputation = [
                            'grade' => $this->UserReputations->getReputation($user->user->id),
                            'qtd' => $this->UserReputations->getCountReputation($user->user->id)
                        ];
                        $projects[$key]->project_users_intersted[$keyUser]->user->fixed = $this->verifyFixedUser($user->user->id, $project['id']);
                    }
                }
            endforeach;
        }

        $this->set(compact('projects'));
        $this->set('_serialize', ['projects']);
    }

    public function add()
    {
        $project = $this->Projects->newEntity();
        if ($this->request->is('post')) {

            $data = $this->request->data;

            if (!empty($data['project_files'][0]['name'])) {
                foreach ($data['project_files'] as $key => $item) {
                    $file = $this->upload($item, 'project_files', $key);
                    $data['project_files'][$key]['file'] = $file;
                    $data['project_files'][$key]['ext'] = pathinfo($file, PATHINFO_EXTENSION);
                }
            } else {
                unset($data['project_files'][0]);
            }

            $project = $this->Projects->patchEntity($project, $data);

            if ($this->Projects->save($project)) {
                $fixTimeline = $this->Projects->fixTimelineDescription(
                    $project->id,
                    'Projeto publicado no dia ' . date('d/m/Y') . ' às ' . date('H:i:s') . '.',
                    'fa fa-globe',
                    'Publicado');

                if ($fixTimeline) {
                    $this->Flash->success(__('Projeto criado com sucesso.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('Não foi possível criar seu projeto, tente novamente por favor.'));
        }
        $Skills = TableRegistry::get('Skills');
        $skills = $Skills->find('list');

        $this->set(compact('project', 'skills'));
        $this->set('_serialize', ['project', 'skills']);

    }

    public function edit($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
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

        $alreadyIntersted = $this->ProjectUsersIntersted->find()
            ->where([
                'user_id' => $this->request->session()->read('Auth.User.id'),
                'project_id' => $id
            ])
            ->first();

        $skills = $this->Projects->find()
            ->contain(['ProjectSkills.Skills'])
            ->where([
                'Projects.id' => $id
            ])
            ->extract('project_skills.{*}.skill');

        $finishedProjects = $this->Users->getFinishedProjects($project->user->id);

        $this->set(compact('project', 'finishedProjects', 'skills', 'alreadyIntersted'));
    }

    public function registerInterested()
    {
        $result = ['status' => 'error', 'data' => ''];

        if ($this->request->is('post')) {
            $data = $this->request->data;

            $newRegister = $this->ProjectUsersIntersted->newEntity();
            $newRegister->user_id = $this->request->session()->read('Auth.User.id');
            $newRegister->project_id = $data['id'];
            if ($this->ProjectUsersIntersted->save($newRegister)) {
                $result = ['status' => 'success', 'data' => ''];
            } else {
                $result = ['status' => 'error', 'data' => ''];
            }
        }
        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }

    public function fixUserProject()
    {
        $result = ['status' => 'error', 'data' => ''];
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $project = $this->Projects->get($data['project']);

            if ($project->already_fixed !== '1') {
                $statusChanged = $this->Projects->changeStatusProject(1, $data['project']);
                $userFixed = $this->Users->fixUserOnProject($data['user'], $data['project']);

                $user = $this->Users->get($data['user']);

                $fixTimeline = $this->Projects->fixTimelineDescription(
                    $data['project'],
                    $user->name . ', foi o freelancer escolhido para o projeto "' . $project->title . '" no dia ' . date('d/m/Y') . ' às ' . date('H:i:s') . '.',
                    'fa fa-coffee',
                    'Andamento');

                if ($statusChanged && $userFixed && $fixTimeline) {
                    $result = ['status' => 'success', 'data' => $data['userName'] . ' foi escolhido como desenvolvedor para seu projeto: ' . $project->title];
                } else {
                    $result = ['status' => 'error', 'data' => 'Não foi possível escolher este desenvolvedor'];
                }
            } else {
                $result = ['status' => 'error', 'data' => 'Este projeto já tem um desenvolvedor'];
            }
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }

    private function verifyFixedUser($user, $project)
    {
        $fixed = $this->ProjectUsersFixed->find()
            ->where([
                'user_id' => $user,
                'project_id' => $project
            ])
            ->limit(1)
            ->first();

        return !empty($fixed) ? true : false;
    }

    public function showPartner()
    {
        $result = ['status' => 'error', 'data' => ''];
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $user = $this->Users->get($data['id']);

            $informations = [
                'id' => $user->id,
                'name' => $user->name,
                'created' => $user->created_at->i18nFormat('dd/MM/yyyy'),
                'picture' => $user->picture,
                'finished' => $this->Users->getFinishedProjects($user->id)
            ];

            if ($user) {
                $result = ['status' => 'success', 'data' => $informations];
            } else {
                $result = ['status' => 'error', 'data' => 'y'];
            }
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }

    public function finishProject()
    {
        $result = ['status' => 'error', 'data' => ''];
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $statusChanged = $this->Projects->changeStatusProject(2, $data['project']);
            $fixStep = $this->Projects->fixTimelineDescription(
                $data['project'],
                'Projeto finalizado no dia ' . date('d/m/Y') . ' às ' . date('H:i:s') . '.',
                'fa fa-check',
                'Finalizado');

            $userIdReputation = $this->ProjectUsersFixed->find()
                ->hydrate(false)
                ->where([
                    'project_id' => $data['project']
                ])
                ->limit(1)
                ->first();

            if ($this->request->session()->read('Auth.User.type') == 'c') {
                $userIdReputation = $userIdReputation['user_id'];
            } else {
                $project = $this->Projects->get($data['project']);

                $userIdReputation = $project->user_id;
            }

            $newRate = $this->UserReputations->newEntity();
            $newRate->project_id = $data['project'];
            $newRate->user_id = $userIdReputation;
            $newRate->grade = (float)$data['rate'];

            $rate = $this->UserReputations->save($newRate);

            if ($statusChanged && $fixStep && $rate) {
                $result = ['status' => 'success', 'data' => ''];
            } else {
                $result = ['status' => 'error', 'data' => ''];
            }
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }

    private function upload($data, $nome_pasta, $key)
    {
        $file = false;

        if (!empty($data['name'])) {
            $partes = explode('.', $data['name']);
            $ext = array_pop($partes);
            $file = 'files/' . $nome_pasta . '/' . $data['name'];
            move_uploaded_file($data['tmp_name'], WWW_ROOT . $file);
        }

        return $file;
    }
}
