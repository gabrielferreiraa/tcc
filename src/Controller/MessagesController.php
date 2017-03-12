<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 */
class MessagesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Users = TableRegistry::get('Users');
    }

    public function index()
    {
        $messages = $this->Messages
            ->find()
            ->contain(['MessageRecords', 'UsersTo', 'UsersFrom'])
            ->where([
                'Messages.to' => $this->request->session()->read('Auth.User.id')
            ])
            ->orWhere([
                'Messages.from' => $this->request->session()->read('Auth.User.id')
            ]);

        $query = $this->request->query;
        if(!empty($query)){
            $participants = $this->Users->find()
                ->contain(['Cities.States'])
                ->where([
                    'Users.name IS NOT NULL',
                    "Users.name <> ''",
                    "Users.name like '%" . $query['search'] . "%'"
                ])
                ->orWhere([
                    "email like '%" . $query['search'] . "%'"
                ])
                ->orWhere([
                    "developer_type like '%" . $query['search'] . "%'"
                ])
                ->order('Users.name');
        }

        $this->set(compact('messages', 'participants'));
        $this->set('_serialize', ['messages', 'participants']);
    }

    public function saveMessage () {
        $result = ['status' => 'error'];
        if($this->request->is('post')){
            $MessageRecords = TableRegistry::get('MessageRecords');
            $data = $this->request->data;

            $newMessage = $MessageRecords->newEntity();
            $newMessage->message_id = $data['id'];
            $newMessage->text = $data['message'];
            $newMessage->created = $data['time'];
            $newMessage->user_id = $this->request->session()->read('Auth.User.id');

            if($MessageRecords->save($newMessage)){
                $result = ['status' => 'success'];
            } else {
                $result = ['status' => 'error'];
            }
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }
}
