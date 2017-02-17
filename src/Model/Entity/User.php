<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $cep
 * @property int $city_id
 * @property string $street
 * @property int $number
 * @property string $neighborhood
 * @property bool $public_address
 * @property string $cel_phone
 * @property string $facebook
 * @property string $linkedin
 * @property string $github
 * @property string $description
 * @property string $developer_type
 * @property string $type
 * @property \Cake\I18n\Time $created_at
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\ProjectUsersFixed[] $project_users_fixed
 * @property \App\Model\Entity\ProjectUsersIntersted[] $project_users_intersted
 * @property \App\Model\Entity\Project[] $projects
 * @property \App\Model\Entity\UserReputation[] $user_reputations
 * @property \App\Model\Entity\UserSkill[] $user_skills
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
