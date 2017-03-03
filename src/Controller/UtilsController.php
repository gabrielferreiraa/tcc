<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class UtilsController extends AppController
{
    public function populateCities () {
        $result = ['status' => 'error', 'data' => ''];

        if($this->request->is('post')){
            $data = $this->request->data;
            $Cities = TableRegistry::get('Cities');

            $response = $Cities->find('list')
                ->where([
                    'state_id' => $data['state']
                ]);

            $response = $response->toArray();

            $result = ['status' => 'success', 'data' => $response];
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }
}
