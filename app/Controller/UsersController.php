<?php

namespace App\Controller;

use App\App;
use App\Action\UserMail;
use App\Action\LoginCheckAction;
use App\Action\SignupCheckAction;

class UsersController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('user');
    }
    public function createAccount()
    {
        App::getInstance()->setTitle("Création de compte");
        if ($this->request->hasPost()) {
            $signupCheckAction = new SignupCheckAction($this->request, $this->session);
            $errorMessage = $signupCheckAction->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $pass_hash = password_hash(htmlspecialchars($this->request->getPostValue('password')), PASSWORD_DEFAULT);
                $user = [
                    'username' => htmlspecialchars($this->request->getPostValue('username')),
                    'email' => htmlspecialchars($this->request->getPostValue('email')),
                    'password' => $pass_hash,
                    'token' => $this->session->get('token')
                ];
                $result = $this->user->create($user);
                if ($result) {
                    $this->flash->success("Votre compte a bien été créé <br> Pour utiliser toutes les fonctionnailtées du site, veuillez valier le mail d'inscription.");
                    $mail = new UserMail;
                    $mail->signupMail($user['email'], $user['username'], $user['token']);
                    $this->session->delete('token');
                    return $this->redirect('?p=users.login');
                }
            }
        }
        $form = new \Core\Form\Form($this->request->getPost());
        $this->render('users.createAccount', compact('form'));
    }

    public function login()
    {
        App::getInstance()->setTitle("Connexion");
        if ($this->request->hasPost()) {
            $loginCheckAction = new LoginCheckAction($this->request, $this->session);
            $errorMessage = $loginCheckAction->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $this->flash->success("Vous êtes connecté");
                $this->dbAuth->login($this->request->getPostValue('username'), $this->request->getPostValue('password'));
                return $this->redirect('?p=users.login');
            }
        }

        $form = new \Core\Form\Form();
        $this->render('users.login', compact('form'));
    }

    public function verifyToken()
    {
        if ($this->request->getGetValue('t') == null & $this->request->getGetValue('username') == null) {
            $this->flash->danger("Aucune clé de Vérification n'a été envoyée");
        }
        $user = $this->user->find($this->request->getGetValue('username'), 'username');
        if ($user->token === $this->request->getGetValue('t')) {
            $this->user->update($user->id, [
                'verifiedAt' => date("Y-m-d H:i:s"),
                'token' => null
            ]);
            $this->flash->success("Le compte a bien été validé. Veuillez vous connecter");
            return $this->redirect('?p=users.login');
        }
        $this->flash->danger("Aucune action a effectuer");
        $this->render('users.verifyToken');
    }
}
