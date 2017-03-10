<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 */
class MessagesController extends AppController
{
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

        $this->set(compact('messages'));
        $this->set('_serialize', ['messages']);
    }
}
