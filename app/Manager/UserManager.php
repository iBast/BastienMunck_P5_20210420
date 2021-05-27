<?php

namespace App\Manager;

use App\App;
use Core\Http\Request;
use App\Action\UserMail;


class UserManager
{

    private $request;
    private $session;

    public function __construct($request, $session)
    {
        $this->request = $request;
        $this->session = $session;
        $this->user = App::getInstance()->getTable('user');
    }

    public function create()
    {
        $user = [
            'username' => $this->request->getPostValue('username'),
            'email' => $this->request->getPostValue('email', Request::TYPE_MAIL),
            'password' => password_hash($this->request->getPostValue('password'), PASSWORD_DEFAULT),
            'token' => $this->session->get($this->request->getPostValue('tokenName'))
        ];
        $result = $this->user->create($user);
        if ($result) {
            $mail = new UserMail;
            $mail->signupMail($user['email'], $user['username'], $user['token']);
        }
        return $result;
    }

    public function recover($email)
    {
        $user = $this->user->find($email, 'email');
        $this->user->update($user->id, [
            'password' => password_hash($this->request->getPostValue('token'), PASSWORD_DEFAULT),
            'passwordLock' => '1'
        ]);
        $mail = new UserMail;
        $mail->recoverMail($user->email, $user->username, $this->request->getPostValue('token'));
    }
}
