<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Cities
 * @property \Cake\ORM\Association\HasMany $ProjectUsersFixed
 * @property \Cake\ORM\Association\HasMany $ProjectUsersIntersted
 * @property \Cake\ORM\Association\HasMany $Projects
 * @property \Cake\ORM\Association\HasMany $UserReputations
 * @property \Cake\ORM\Association\HasMany $UserSkills
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id'
        ]);
        $this->hasMany('ProjectUsersFixed', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ProjectUsersIntersted', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Projects', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserReputations', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserSkills', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsToMany('Skills', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'skill_id',
            'joinTable' => 'user_skills'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->allowEmpty('cep');

        $validator
            ->allowEmpty('street');

        $validator
            ->integer('number')
            ->allowEmpty('number');

        $validator
            ->allowEmpty('neighborhood');

        $validator
            ->boolean('public_address')
            ->allowEmpty('public_address');

        $validator
            ->allowEmpty('cel_phone');

        $validator
            ->allowEmpty('facebook');

        $validator
            ->allowEmpty('linkedin');

        $validator
            ->allowEmpty('github');

        $validator
            ->allowEmpty('description');

        $validator
            ->allowEmpty('developer_type');

        $validator
            ->allowEmpty('type');

        $validator
            ->allowEmpty('created_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }

    public function getTypeUser($type, $ab = false)
    {
        if ($ab) {
            return $type == 'freelancer' ? 'f' : 'c';
        }

        return $type == 'f' ? 'freelancer' : 'contratante';
    }

    public function isValidEmail($email, $type)
    {
        $user = $this->find()
            ->hydrate(false)
            ->select([
                'email'
            ])
            ->where([
                'type' => $type,
                'email' => $email
            ])
            ->limit(1)
            ->first();

        if (count($user)) {
            return false;
        } else {
            return true;
        }
    }

    public function getFinishedProjects($user)
    {
        $Projects = TableRegistry::get('Projects');
        $ProjectUsersFixed = TableRegistry::get('ProjectUsersFixed');
        $person = $this->get($user);

        if ($person->type == 'f') {
            $count = $ProjectUsersFixed->find()
                ->select([
                    'count' => 'COUNT(*)'
                ])
                ->innerJoin(['p' => 'projects'], ['p.id = ProjectUsersFixed.project_id'])
                ->where([
                    'p.status' => 2,
                    'ProjectUsersFixed.user_id' => $user
                ])
                ->first();

            if (count($count)) {
                $count = $count->toArray();
                $count = $count['count'];
            } else {
                $count = 0;
            }
        } else {
            $count = $Projects->find()
                ->select([
                    'count' => 'COUNT(*)'
                ])
                ->where([
                    'status' => 2,
                    'user_id' => $user
                ])
                ->first();

            if(!empty($count)) {
                $count = $count->count;
            } else {
                $count = 0;
            }
         }

        return $count;
    }

    public function fixUserOnProject($user, $project)
    {
        $Projects = TableRegistry::get('Projects');
        $ProjectUsersFixed = TableRegistry::get('ProjectUsersFixed');

        $newRegister = $ProjectUsersFixed->newEntity();

        $newRegister->user_id = $user;
        $newRegister->project_id = $project;

        if ($ProjectUsersFixed->save($newRegister)) {
            $alreadyFixed = $Projects->query()->update()
                ->set([
                    'already_fixed' => 1
                ])
                ->where([
                    'id' => $project
                ]);
            if ($alreadyFixed->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getProjectsUser($userId, $type)
    {
        if ($type == 'f') {
            $projects = $this->Projects->find()
                ->contain([
                    'Users',
                    'UserReputations'
                ])
                ->innerJoin(['puf' => 'project_users_fixed'], ['puf.project_id = Projects.id'])
                ->where([
                    'puf.user_id' => $userId,
                    'status' => 2
                ])
                ->order('Projects.id DESC')
                ->limit(3);

        } else {
            $projects = $this->Projects->find()
                ->contain([
                    'UserReputations',
                    'ProjectUsersFixed.Users'
                ])
                ->where([
                    'Projects.user_id' => $userId,
                    'status' => 2
                ])
                ->order('Projects.id DESC')
                ->limit(3);

        }

        if ($projects->count()) {
            $projects = $projects->toArray();
        } else {
            $projects = [];
        }

        return $projects;
    }

    public function changeStatusUser($userId, $isOnline)
    {
        $this->query()->update()
            ->set([
                'is_online' => $isOnline,
            ])
            ->where([
                'id' => $userId
            ])
            ->execute();
    }
}
