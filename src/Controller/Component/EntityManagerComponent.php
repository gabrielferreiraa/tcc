<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;

/**
 * XLSXImporter component
 */
class EntityManagerComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function deleteChildByIdNotIn($EntityTable, $parentId, $parentField, $data = false) {

        if ($data) {
            $childIds = [];
            foreach ($data as $item) {
                if (isset($item['id']) && !empty($item['id'])) {
                    array_push($childIds, $item['id']);
                }
            }

            if (count($childIds)) {
                $EntityTable->deleteAll(['id not in' => $childIds]);
            } else {
                $EntityTable->deleteAll([$parentField => $parentId]);
            }
        } else {
            $EntityTable->deleteAll([$parentField => $parentId]);
        }
    }

}
