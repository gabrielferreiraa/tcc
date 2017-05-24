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

        if (isset($query['search']) && !empty($query['search'])) {
            $participants = $this->Users->find()
                ->contain(['Cities.States'])
                ->where([
                    "Users.name like '%" . $query['search'] . "%'",
                    'Users.id <>' => $this->request->session()->read('Auth.User.id')
                ])
                ->orWhere([
                    "email like '%" . $query['search'] . "%'"
                ])
                ->orWhere([
                    "developer_type like '%" . $query['search'] . "%'"
                ])
                ->order('Users.name');
        } else {
            $participants = $this->Users->find()
                ->contain(['Cities.States'])
                ->where([
                    'Users.id <>' => $this->request->session()->read('Auth.User.id')
                ])
                ->order('Users.name');
        }

        $participants = $this->paginate($participants);

        $this->set(compact('messages', 'participants'));
        $this->set('_serialize', ['messages', 'participants']);
    }

    public function saveMessage()
    {
        $result = ['status' => 'error'];
        if ($this->request->is('post')) {
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

            if ($this->MessageRecords->save($newMessage)) {
                $result = ['status' => 'success'];
            } else {
                $result = ['status' => 'error'];
            }
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }

    public function newMesseger()
    {
        $result = ['status' => 'error'];
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $participantOnlineId = $this->request->session()->read('Auth.User.id');
            $hasOpenTalk = $this->hasOpenTalk($participantOnlineId, $data['id']);

            if ($hasOpenTalk) {
                if ($this->MessageRecords->newRecord($hasOpenTalk, $data['message'], $participantOnlineId)) {
                    $result = ['status' => 'success'];
                } else {
                    $result = ['status' => 'error'];
                }
            } else {
                $message = $this->Messages->newEntity();
                $message->to_user = $participantOnlineId;
                $message->from_user = $data['id'];
                $message->date = date('Y-m-d H:i:s');

                $sended = $this->Messages->save($message);

                if ($sended) {
                    if ($this->MessageRecords->newRecord($sended->id, $data['message'], $participantOnlineId)) {
                        $result = ['status' => 'success'];
                    } else {
                        $result = ['status' => 'error'];
                    }
                }
            }
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);
    }

    private function hasOpenTalk($user1, $user2)
    {
        $talk = $this->Messages->find()
            ->where([
                'to_user' => $user1,
                'from_user' => $user2
            ])
            ->orWhere([
                'from_user' => $user1,
                'to_user' => $user2
            ])
            ->first();

        if (!empty($talk)) {
            return $talk->id;
        }

        return;
    }
}
