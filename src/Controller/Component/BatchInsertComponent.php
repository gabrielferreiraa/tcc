<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * XLSXImporter component
 */
class BatchInsertComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $components = ['Task'];
    public $totalData = [];
    public $currentData = [];

    public function insert($entity, $data, $limit, $fixed = [], $task = false, $childData = false) {
        $results = [];
        $childResults = [];
        $count = 0;
        $lastId = 0;

        if ($childData) {
            $last = TableRegistry::get($entity)->find()->select(['id'])->order(['id desc'])->first();
            if ($last) {
                $lastId = $last->id;
            }
        }

        if (count($data)) {
            if (!isset($this->totalData[$entity])) {
                $this->totalData[$entity] = count($data);
            }
            if (!isset($this->currentData[$entity])) {
                $this->currentData[$entity] = 0;
            }

            foreach ($data as $key => $row) {
                $count++;
                if ($count <= $limit) {
                    if ($childData) {
                        $lastId++;
                        $row['id'] = $lastId;
                        foreach ($childData[$key] as $childEntity => $child) {
                            foreach ($child as $childItem) {
                                $fk = $childItem['foreignKey'];
                                $childRow = $childItem['data'];
                                $childRow[$fk] = $lastId;
                                if (!isset($childResults[$childEntity])) {
                                    $childResults[$childEntity] = [];
                                }
                                array_push($childResults[$childEntity], $childRow);
                            }
                        }
                    }
                    array_push($results, $row);
                    unset($data[$key]);
                    if ($childData && isset($childData[$key])) {
                        unset($childData[$key]);
                    }
                } else {
                    $this->currentData[$entity]+=$limit;
                    break;
                }
            }

            if ($results) {
                if ($this->save($results, $entity, $fixed)) {
                    if ($childResults) {
                        foreach ($childResults as $childEntity => $childResult) {
                            if (!$this->insert($childEntity, $childResult, $limit, [], $task)) {
                                return false;
                            }
                        }
                    }
                    if ($task) {
                        $percent = ceil(($this->currentData[$entity] / $this->totalData[$entity]) * 100);
                        $this->Task->update($task, $percent, 'Salvando');
                    }
                    usleep(100000);
                    return $this->insert($entity, $data, $limit, $fixed, $task, $childData);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function save($data, $entity, $fixed) {

        $fields = array_keys($data[0]);

        if (count($fixed)) {
            $fields = array_merge($fields, array_keys($fixed));
            foreach ($data as $key => $value) {
                $data[$key] = array_merge($data[$key], $fixed);
            }
        }

        $query = TableRegistry::get($entity)->query();
        $query->insert($fields);
        $query->clause('values')->values($data);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
