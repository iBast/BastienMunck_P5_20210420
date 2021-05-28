<?php

namespace App\Manager;

use App\App;
use Core\Http\Request;
use App\Action\UserMail;
use Core\Http\ImgUpload;


class UserManager
{

    private $request;
    private $session;
    private $flash;

    public function __construct($request, $session, $flash)
    {
        $this->request = $request;
        $this->session = $session;
        $this->flash = $flash;
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

    public function passwordUpdate($email)
    {
        $user = $this->user->find($email, 'email');
        $this->user->update($user->id, [
            'password' => password_hash($this->request->getPostValue('password'), PASSWORD_DEFAULT),
            'passwordLock' => '0'
        ]);
    }

    public function updateAccount()
    {
        $user = $this->user->find($this->session->get('auth'));
        $message = '';
        if ($this->imgUpload('pic', $user->id) != "") {
            $this->imgUpload('pic', $user->id);
            $this->user->update($user->id, ['profilePic' => $this->imgUpload('pic', $user->id)]);
            $message .= 'La photo de profil a été mise à jour <br>';
        }

        if ($this->request->getPostValue('username') != '') {
            $this->user->update($user->id, ['username' => $this->request->getPostValue('username')]);
            $message .= 'Un nouveau nom d\'utilisateur a été enregistré <br>';
        }
        if ($this->request->getPostValue('email') != '') {
            $this->user->update($user->id, [
                'email' => $this->request->getPostValue('email'),
                'token' => $this->request->getPostValue('token'),
                'verifiedAt' => null
            ]);
            $mail = new UserMail;
            $mail->signupMail($user->email, $user->username, $user->token);
            $message .= 'Une nouvelle adresse mail a été enregistrée <br> Pour utiliser toutes les fonctionnailtées du site, veuillez valider le mail envoyé.';
        }
        $this->flash->success($message);
    }

    public function deleteAccount()
    {
        $this->user->delete($this->session->get('auth'));
        $this->session->delete('auth');
    }

    public function imgUpload($key, $id)
    {
        $imgUpload = new ImgUpload('avatar');
        return $imgUpload->resizeImage($key, $id);
    }
}
