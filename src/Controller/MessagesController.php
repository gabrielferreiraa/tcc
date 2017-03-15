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
    public $paginate = ['limit' => 10];

    public function initialize()
    {
        parent::initialize();
        $this->Users = TableRegistry::get('Users');
        $this->MessageRecords = TableRegistry::get('MessageRecords');
    }

    public function index()
    {
        $messages = $this->Messages
            ->find()
            ->contain(['MessageRecords', 'UsersTo', 'UsersFrom'])
            ->where([
                'Messages.to_user' => $this->request->session()->read('Auth.User.id')
            ])
            ->orWhere([
                'Messages.from_user' => $this->request->session()->read('Auth.User.id')
            ])
            ->order('date DESC');

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

            $participants = $this->paginate($participants);
        }

        $this->set(compact('messages', 'participants'));
        $this->set('_serialize', ['messages', 'participants']);
    }

    public function saveMessage () {
        $result = ['status' => 'error'];
        if($this->request->is('post')){
            $data = $this->request->data;

            $this->Messages->query()
                ->update()
                ->set([
                    'date' => date('Y-m-d H:i:s')
                ])
                ->where([
                    'id' => $data['id']
                ])
                ->execute();

            $newMessage = $this->MessageRecords->newEntity();
            $newMessage->message_id = $data['id'];
            $newMessage->text = $data['message'];
            $newMessage->created = date('Y-m-d H:i:s');
            $newMessage->user_id = $this->request->session()->read('Auth.User.id');

            if($this->MessageRecords->save($newMessage)){
                $result = ['status' => 'success'];
            } else {
                $result = ['status' => 'error'];
            }
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }

    public function newMesseger () {
        $result = ['status' => 'error'];
        if($this->request->is('post')){
            $data = $this->request->data;

            $message = $this->Messages->newEntity();
            $message->to_user = $this->request->session()->read('Auth.User.id');
            $message->from_user = $data['id'];
            $message->date = date('Y-m-d H:i:s');

            $sended = $this->Messages->save($message);

            if($sended){
                $messageRecord = $this->MessageRecords->newEntity();
                $messageRecord->message_id = $sended->id;
                $messageRecord->text = $data['message'];
                $messageRecord->created = date('Y-m-d H:i:s');
                $messageRecord->user_id = $this->request->session()->read('Auth.User.id');

                if($this->MessageRecords->save($messageRecord)){
                    $result = ['status' => 'success'];
                } else {
                    $result = ['status' => 'error'];
                }
            }
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }
}
