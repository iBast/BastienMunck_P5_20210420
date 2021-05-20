<?php

namespace App\Controller;

use App\Action\SignupCheckAction;
use App\Action\UserMail;


class UsersController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('user');
    }
    public function createAccount()
    {
        $signupCheckAction = new SignupCheckAction($this->request, $this->session);
        if ($this->request->hasPost()) {
            $errorMessage = $signupCheckAction->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $pass_hash = password_hash(htmlspecialchars($this->request->getPostValue('password')), PASSWORD_DEFAULT);
                $user = [
                    'name' => htmlspecialchars($this->request->getPostValue('name')),
                    'email' => htmlspecialchars($this->request->getPostValue('email')),
                    'password' => $pass_hash,
                    'token' => $this->session->get('token')
                ];
                $result = $this->user->create($user);
                if ($result) {
                    $this->flash->success("Votre compte a bien été créé <br> Pour utiliser toutes les fonctionnailtées du site, veuillez valier le mail d'inscription.");
                    $mail = new UserMail;
                    $mail->signupMail($user['email'], $user['name'], $user['token']);
                    $this->session->delete('token');
                    return $this->login();
                }
            }
        }
        $form = new \Core\Form\Form($_POST);
        $this->render('users.createAccount', compact('form'));
    }

    public function login()
    {
        $form = new \Core\Form\Form();
        $this->render('users.login', compact('form'));
    }

    public function verifyToken()
    {
        if ($this->request->getGetValue('t') == null & $this->request->getGetValue('username') == null) {
            $this->flash->danger("Aucune clé de Vérification n'a été envoyée");
        }
        $user = $this->user->find($this->request->getGetValue('username'), 'name');
        var_dump($user);
        if ($user->token === $this->request->getGetValue('t')) {
            $this->user->update($user->id, [
                'verifiedAt' => date("Y-m-d H:i:s"),
                'token' => null
            ]);
            $this->flash->success("Le compte a bien été validé. Veuillez vous connecter");
            return $this->login();
        }
        $this->flash->danger("Aucune action a effectuer");
        $this->render('users.verifyToken');
    }
}
