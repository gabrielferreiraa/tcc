<?php
namespace Admin\Test\TestCase\Controller;

use Admin\Controller\SkillsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * Admin\Controller\SkillsController Test Case
 */
class SkillsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.admin.skills',
        'plugin.admin.project_skills',
        'plugin.admin.projects',
        'plugin.admin.users',
        'plugin.admin.cities',
        'plugin.admin.states',
        'plugin.admin.project_users_fixed',
        'plugin.admin.project_users_intersted',
        'plugin.admin.user_reputations',
        'plugin.admin.user_skills',
        'plugin.admin.project_steps',
        'plugin.admin.files',
        'plugin.admin.project_files'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
