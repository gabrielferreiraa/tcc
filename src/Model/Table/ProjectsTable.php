<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Projects Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $ProjectFiles
 * @property \Cake\ORM\Association\HasMany $ProjectSkills
 * @property \Cake\ORM\Association\HasMany $ProjectUsersFixed
 * @property \Cake\ORM\Association\HasMany $ProjectUsersIntersted
 * @property \Cake\ORM\Association\HasMany $UserReputations
 *
 * @method \App\Model\Entity\Project get($primaryKey, $options = [])
 * @method \App\Model\Entity\Project newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Project[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Project|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Project patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Project[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Project findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjectsTable extends Table
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

        $this->table('projects');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ProjectFiles', [
            'foreignKey' => 'project_id'
        ]);
        $this->hasMany('ProjectSkills', [
            'foreignKey' => 'project_id'
        ]);
        $this->hasMany('ProjectUsersFixed', [
            'foreignKey' => 'project_id'
        ]);
        $this->hasMany('ProjectUsersIntersted', [
            'foreignKey' => 'project_id'
        ]);
        $this->hasMany('UserReputations', [
            'foreignKey' => 'project_id'
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
            ->allowEmpty('title');

        $validator
            ->allowEmpty('description');

        $validator
            ->date('date_end')
            ->allowEmpty('date_end');

        $validator
            ->numeric('budget')
            ->allowEmpty('budget');

        $validator
            ->integer('type_area')
            ->allowEmpty('type_area');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    public function getStatus($status)
    {
        $possibleStatus = [
            0 => [
                'title' => 'Publicado',
                'icon' => 'fa fa-globe'
            ],
            1 => [
                'title' => 'Andamento',
                'icon' => 'fa fa-coffee'
            ],
            2 => [
                'title' => 'Finalizado',
                'icon' => 'fa fa-check'
            ]
        ];

        return $possibleStatus[$status];
    }

    public function changeStatusProject($status, $project)
    {
        $updated = $this->query()
            ->update()
            ->set([
                'status' => $status
            ])
            ->where([
                'id' => $project
            ]);

        if ($updated->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getStepProject($projectStatus)
    {
        $status = $this->getStatus($projectStatus['id']);

        $step = 1;

        switch (strtolower($status['title'])) {
            case 'publicado':
                $step = 1;
                break;
            case 'andamento':
                $step = 2;
                break;
            case 'finalizado':
                $step = 3;
                break;
            default:
                $step = 1;
                break;
        }

        return $step;
    }

    public function fixTimelineDescription($project, $description)
    {
        $ProjectSteps = TableRegistry::get('ProjectSteps');

        $newRegister = $ProjectSteps->newEntity();
        $newRegister->project_id = $project;
        $newRegister->description = $description;
        $newRegister->created = date('Y-m-d H:i:s');

        if ($ProjectSteps->save($newRegister)) {
            return true;
        } else {
            return false;
        }
    }
}
