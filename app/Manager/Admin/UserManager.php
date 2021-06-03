<?php

namespace App\Manager\Admin;

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


    public function updateAccount()
    {
        $user = $this->user->find($this->request->getGetValue('id'));
        $message = '';
        if ($this->imgUpload('profilePic', $user->id) != "") {
            $this->imgUpload('profilePic', $user->id);
            $this->user->update($user->id, ['profilePic' => $this->imgUpload('profilePic', $user->id)]);
            $message .= 'La photo de profil a été mise à jour <br>';
        }

        if ($this->request->getPostValue('username') != $user->username) {
            $this->user->update($user->id, ['username' => $this->request->getPostValue('username')]);
            $message .= 'Un nouveau nom d\'utilisateur a été enregistré <br>';
        }
        if ($this->request->getPostValue('role') != $user->role) {
            $this->user->update($user->id, ['role' => $this->request->getPostValue('role')]);
            $message .= 'Le rôle de l\'utilisateur ' . $user->username . ' a bien été enregistré <br>';
        }
        if ($this->request->getPostValue('email') != $user->email) {
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
        $this->user->delete($this->request->getPostValue('userid'));
        $this->flash->success('L\'utilisateur a été supprimé');
    }

    public function imgUpload($key, $userId)
    {
        $imgUpload = new ImgUpload('avatar');
        return $imgUpload->resizeImage($key, $userId);
    }
}
