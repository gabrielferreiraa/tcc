<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserReputations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\UserReputation get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserReputation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserReputation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserReputation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserReputation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserReputation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserReputation findOrCreate($search, callable $callback = null, $options = [])
 */
class UserReputationsTable extends Table
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

        $this->table('user_reputations');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
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
            ->numeric('grade')
            ->allowEmpty('grade');

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
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
    
    public function getReputation ($user) {
        $reputation = $this->find()
            ->select([
               'reputation' => 'ROUND(AVG(grade))' 
            ])
            ->where([ 
                'user_id' => $user
            ])
            ->first();
        if(empty($reputation)) {
            $reputation = 0;
        } else {
            $reputation = $reputation->reputation;
        }
        
        return $reputation;
    }
}
