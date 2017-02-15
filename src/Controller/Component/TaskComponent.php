<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;

/**
 * XLSXImporter component
 */
class TaskComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    private $cacheConfig = 'redis';

    public function start($taskName, $status = 'Started', $identifier = 'Task') {
        $taskData = [
            'status' => $status,
            'identifier' => $identifier,
            'progress' => 0,
            'type' => 'running'
        ];

        Cache::write($taskName, $taskData, $this->cacheConfig);
    }

    public function update($taskName, $progress, $status = false) {
        $taskData = Cache::read($taskName, $this->cacheConfig);

        $taskData['progress'] = $progress;
        $taskData['type'] = 'running';

        if ($status) {
            $taskData['status'] = $status;
        }

        Cache::write($taskName, $taskData, $this->cacheConfig);
    }

    public function check($taskName, $type = false) {
        $task = Cache::read($taskName, $this->cacheConfig);
        
        if ($task) {
            if ($type) {
                if ($task['type'] == $type) {
                    return $task;
                } else {
                    return false;
                }
            } else {
                return $task;
            }
        } else {
            return false;
        }
    }

    public function setIdentifier($taskName, $identifier = 'Task') {
        $taskData = Cache::read($taskName, $this->cacheConfig);

        $taskData['identifier'] = $identifier;

        Cache::write($taskName, $taskData, $this->cacheConfig);
    }

    public function complete($taskName) {
        $taskData = Cache::read($taskName, $this->cacheConfig);

        $taskData['type'] = 'completed';
        $taskData['progress'] = 100;

        Cache::write($taskName, $taskData, $this->cacheConfig);
    }

    public function error($taskName, $description = '', $details = '') {
        $taskData = Cache::read($taskName, $this->cacheConfig);

        $taskData['type'] = 'error';
        $taskData['description'] = $description;
        $taskData['details'] = $details;

        Cache::write($taskName, $taskData, $this->cacheConfig);
    }

    public function end($taskName) {
        Cache::delete($taskName, $this->cacheConfig);
    }

}
