<?php

namespace App\Controller;

use App\App;
use App\Action\UserMail;
use App\Action\LoginCheckAction;
use App\Action\SignupCheckAction;
use App\Action\RecoverCheckAction;
use App\Manager\UserManager;

class UsersController extends AppController
{
    private $manager;

    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($this->session, $this->flash, $this->request, $this->dbAuth);
        $this->session = $session;
        $this->flash = $flash;
        $this->request = $request;
        $this->dbAuth = $dbAuth;
        $this->loadModel('user');
        $this->manager = new UserManager($this->request, $this->session);
    }
    public function signup()
    {
        App::getInstance()->setTitle("Création de compte");
        if ($this->request->hasPost()) {
            $signupCheckAction = new SignupCheckAction($this->request, $this->session);
            $errorMessage = $signupCheckAction->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                if ($this->manager->create()) {
                    $this->flash->success("Votre compte a bien été créé <br> Pour utiliser toutes les fonctionnailtées du site, veuillez valider le mail d'inscription.");
                    return $this->redirect('?p=users.login');
                }
            }
        }
        $form = new \Core\Form\Form($this->request->getPost());
        $this->render('users.signup', compact('form'));
    }

    public function login()
    {
        App::getInstance()->setTitle("Connexion");
        if ($this->request->hasPost()) {
            $loginCheckAction = new LoginCheckAction($this->request, $this->session);
            $errorMessage = $loginCheckAction->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $this->dbAuth->login($this->request->getPostValue('username'), $this->request->getPostValue('password'));
                return $this->redirect('?p=users.account');
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
            if ($this->session->get('auth') == null) {
                $this->flash->success("Le compte a bien été validé. Veuillez vous connecter");
                return $this->redirect('?p=users.login');
            }
            $this->flash->success("Le compte a bien été validé.");
            return $this->redirect('?p=users.account');
        }
        $this->flash->danger("Aucune action a effectuer");
        $this->render('users.verifyToken');
    }

    public function account()
    {
        if ($this->session->get('auth') == null) {
            $this->flash->danger('Vous devez être connecté pour voir cette page');
            $this->redirect('?p=users.login');
        }
        $user = $this->user->find($this->session->get('auth'));
        if ($user->verifiedAt == null) {
            $this->flash->warning('Votre compte est toujours en attente de validation <br> <a href="?p=users.resendmail">Cliquez ici pour renvoyer le mail d\'activation</a>');
        }
        $this->render('users.account', compact('user'));
    }

    public function logout(): void
    {
        $this->dbAuth->logout();
        $this->redirect('index.php');
    }

    public function resendmail(): void
    {
        $user = $this->user->find($this->session->get('auth'));
        if ($user->token == null) {
            $this->flash->danger('Pas de vérification a faire pour cet utilisateur');
            $this->redirect('?p=users.account');
        }
        if ($user) {
            $mail = new UserMail;
            $mail->signupMail($user->email, $user->username, $user->token);
            $this->redirect('?p=users.account');
        }
        $this->flash->danger('Aucun n\'utilisateur n\'a été renseigné');
        $this->redirect('index.php');
    }

    public function recover()
    {
        App::getInstance()->setTitle("Mot de passe oublié");
        if ($this->request->hasPost()) {
            $recoverCheckAction = new RecoverCheckAction($this->request, $this->session);
            $errorMessage = $recoverCheckAction->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $this->manager->recover($this->request->getPostValue('email'));
                $this->flash->success('Un email vous a été envoyé avec un nouveau mot de passe <br> un changement de mot de passe sera exigé à la prochaine connexion');
                $this->redirect('index.php');
            }
        }
        $form = new \Core\Form\Form($this->request->getPost());
        $this->render('users.recover', compact('form'));
    }

    public function changePassword()
    {
        App::getInstance()->setTitle("Modification du mot de passe");
        $user = $this->user->find($this->request->getGetValue('username'), 'username');
        if ($user->recoverToken === $this->request->getGetValue('t')) {
            $this->user->update($user->id, [
                'password' => password_hash($this->request->getPostValue('password'), PASSWORD_DEFAULT)
            ]);
            if ($this->session->get('auth') == null) {
                $this->flash->success("Le compte a bien été validé. Veuillez vous connecter");
                return $this->redirect('?p=users.login');
            }
            $this->flash->success("Le compte a bien été validé.");
            return $this->redirect('?p=users.account');
        }

        $form = new \Core\Form\Form($this->request->getPost());
        $this->render('users.reset', compact('form'));
    }
}
