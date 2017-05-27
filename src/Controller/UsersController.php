<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow('registerContractor');
        $this->Auth->allow('registerFreelancer');
        $this->Auth->allow('add');
        $this->Auth->allow('saveUser');

        $this->UserReputations = TableRegistry::get('UserReputations');
        $this->States = TableRegistry::get('States');
        $this->Skills = TableRegistry::get('Skills');
        $this->ProjectUsersFixed = TableRegistry::get('ProjectUsersFixed');
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
        $type = $this->Users->getTypeUser($type, true);
        $typeText = $this->Users->getTypeUser($type);

        $this->set(compact('email', 'type', 'typeText'));
        $this->set('_serialize', ['email', 'type', 'typeText']);
    }

    public function saveUser()
    {
        $result = ['status' => 'error', 'text' => 'Não foi possível realizar o cadastro'];
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if ($this->Users->isValidEmail($data['email'], $this->Users->getTypeUser($data['type'], true))) {
                $user = $this->Users->newEntity();
                $user = $this->Users->patchEntity($user, $data);
                $user->type = $data['type'];
                $user->created_at = date('Y-m-d');

                if ($this->Users->save($user)) {
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

    public function view()
    {
        $user = $this->Users->find()
            ->contain(['Cities.States', 'UserSkills.Skills'])
            ->leftJoin(['c' => 'cities'], ['c.id = Users.city_id'])
            ->leftJoin(['s' => 'states'], ['c.state_id = s.id'])
            ->where([
                'email' => $this->request->session()->read('Auth.User.email')
            ])
            ->first();

        $reputation = [
            'grade' => $this->UserReputations->getReputation($user->id),
            'qtd' => $this->UserReputations->getCountReputation($user->id)
        ];

        if (!empty($user)) {
            $user = $user->toArray();
            $null = 0;
            $complete = 0;
            foreach ($user as $field) {
                if (is_null($field)) {
                    $null++;
                } else {
                    $complete++;
                }
            }

            $projectsUser = $this->Users->getProjectsUser($user['id'], $user['type']);
            $finishedProjects = $this->Users->getFinishedProjects($user['id']);

            $percentageProfile = round(($complete / $null) * 100);
        }

        $Projects = TableRegistry::get('Projects');

        $totalBudget = $Projects
            ->find()
            ->select([
                'total' => "(CASE WHEN SUM(CAST(REPLACE(REPLACE(budget, '.', ''), ',', '.') AS DECIMAL)) IS NULL THEN 0.00 ELSE SUM(CAST(REPLACE(REPLACE(budget, '.', ''), ',', '.') AS DECIMAL)) END)"
            ])
            ->where([
                'user_id = ' . $this->request->session()->read('Auth.User.id'),
                'status = ' . 2
            ])
            ->order('user_id')
            ->first();

        $this->set('totalBudget', $totalBudget);
        $this->set('reputation', $reputation);
        $this->set('finishedProjects', $finishedProjects);
        $this->set('percentageProfile', $percentageProfile);
        $this->set('user', $user);
        $this->set('projectsUser', $projectsUser);
        $this->render('profile');
    }

    public function viewProfile($id)
    {
        if ($id == $this->request->session()->read('Auth.User.id')) {
            return $this->redirect('/perfil');
        }

        $user = $this->Users->get($id, ['contain' => ['Cities.States', 'UserSkills.Skills']]);

        $reputation = [
            'grade' => $this->UserReputations->getReputation($user->id),
            'qtd' => $this->UserReputations->getCountReputation($user->id)
        ];

        if ($user) {
            $user = $user->toArray();
        }

        $finishedProjects = $this->Users->getFinishedProjects($id);
        $projectsUser = $this->Users->getProjectsUser($id, $user['type']);

        $Projects = TableRegistry::get('Projects');

        $totalBudget = $Projects
            ->find()
            ->select([
                'total' => "(CASE WHEN SUM(CAST(REPLACE(REPLACE(budget, '.', ''), ',', '.') AS DECIMAL)) IS NULL THEN 0.00 ELSE SUM(CAST(REPLACE(REPLACE(budget, '.', ''), ',', '.') AS DECIMAL)) END)"
            ])
            ->where([
                'user_id' => $user['id'],
                'status' => 2
            ])
            ->order('user_id')
            ->first();

        $this->set(compact('user', 'projectsUser', 'skills', 'finishedProjects', 'reputation', 'totalBudget'));
    }

    public function edit()
    {
        $user = $this->Users->find()
            ->where([
                'email' => $this->request->session()->read('Auth.User.email')
            ])
            ->first();

        $user = $this->Users->get($user->id, [
            'contain' => ['Cities', 'Skills']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;

            $data['public_address'] = isset($data['public_address']) && $data['public_address'] == 'on' ? 1 : 0;
            if (empty($data['picture']) && !empty($user->picture)) {
                $data['picture'] = $user->picture;
            }

            $userUpdated = $this->Users->patchEntity($user, $data);

            $name = explode(' ', $userUpdated->name);

            if ($this->Users->save($userUpdated)) {
                $this->Flash->success(__($name[0] . ', seu cadastro foi atualizado com sucesso'));

                return $this->redirect(['action' => 'view']);
            }
            $this->Flash->error(__($name[0] . ', não foi possível atualizar seu cadastro'));
        }

        $states = $this->States->find('list');
        $skills = $this->Skills->find('list');

        $this->set(compact('user', 'states', 'skills'));
        $this->set('_serialize', ['user', 'states', 'skills']);
    }
}