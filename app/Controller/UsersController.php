<?php

namespace App\Controller;

use App\App;
use Core\Http\Request;
use App\Action\UserMail;
use App\Manager\UserManager;
use App\Action\LoginCheckAction;
use App\Action\SignupCheckAction;
use App\Action\RecoverCheckAction;
use App\Action\ChangePassCheckAction;
use App\Action\DeleteAccountCheckAction;
use App\Action\UpdateAccountCheckAction;
use Core\Form\Form;

/**
 * UsersController
 */
class UsersController extends AppController
{
    private $manager;

    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($session, $flash, $request, $dbAuth);
        $this->loadModel('user');
        $this->loadModel('comment');
        $this->manager = new UserManager($request, $session, $flash);
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
                if ($this->session->get('auth') != null) {
                    return $this->redirect('?p=users.account');
                }
                return $this->redirect('?p=users.changePassword');
            }
        }

        $form = new \Core\Form\Form();
        $this->render('users.login', compact('form'));
    }

    /**
     * verifyToken verify the user email adress
     */
    public function verifyToken()
    {
        if ($this->request->getGetValue('t') == null & $this->request->getGetValue('username') == null) {
            $this->flash->danger("Aucune clé de Vérification n'a été envoyée");
        }
        $user = $this->user->find($this->request->getGetValue('username'), 'username');
        if ($user->token === $this->request->getGetValue('t')) {
            $this->user->update($user->id, [
                'verifiedAt' => date("Y-m-d H:i:s"),
                'token' => null,
                'role' => 1
            ]);
            if ($this->session->get('auth') == null) {
                $this->flash->success("Le compte a bien été validé. Veuillez vous connecter");
                return $this->redirect('?p=users.login');
            }
            $this->flash->success("Le compte a bien été validé.");
            return $this->redirect('?p=users.account');
        }
        $this->flash->danger("Aucune action a effectuer");
        $this->render('infos.home');
    }

    /**
     * account access the user  in session account page
     */
    public function account()
    {
        App::getInstance()->setTitle("Mon compte");
        if ($this->session->get('auth') == null) {
            $this->flash->danger('Vous devez être connecté pour voir cette page');
            $this->redirect('?p=users.login');
        }
        $user = $this->user->find($this->session->get('auth'));
        if ($user->verifiedAt == null) {
            $this->flash->warning('Votre compte est toujours en attente de validation <br> <a href="?p=users.resendmail">Cliquez ici pour renvoyer le mail d\'activation</a>');
        }
        $commentStatus = array(0 => 'warning', 1 => 'valid', 2 => 'danger');
        $comments = $this->comment->commentFromUser($user->id);
        $form = new Form();
        $this->render('users.account', compact('user', 'comments', 'form', 'commentStatus'));
    }

    public function logout(): void
    {
        $this->dbAuth->logout();
        $this->redirect('index.php');
    }

    /**
     * resendmail to verify the user email
     */
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

    /**
     * recover of forgotten password, send a mail with a new password and force the user to change the password
     */
    public function recover()
    {
        App::getInstance()->setTitle("Mot de passe oublié");
        if ($this->request->hasPost()) {
            $recoverCheckAction = new RecoverCheckAction($this->request, $this->session);
            $errorMessage = $recoverCheckAction->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $this->manager->recover($this->request->getPostValue('email', Request::TYPE_MAIL));
                $this->flash->success('Un email vous a été envoyé avec un nouveau mot de passe <br> un changement de mot de passe sera exigé à la prochaine connexion');
                $this->redirect('?p=users.changePassword');
            }
        }
        $form = new \Core\Form\Form($this->request->getPost());
        $this->render('users.recover', compact('form'));
    }

    /**
     * changePassword of the current user in session
     */
    public function changePassword()
    {
        App::getInstance()->setTitle("Modification du mot de passe");
        if ($this->request->hasPost()) {
            $changePassCheckAction = new ChangePassCheckAction($this->request, $this->session);
            $errorMessage = $changePassCheckAction->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $this->manager->passwordUpdate($this->request->getPostValue('email'), Request::TYPE_MAIL);
                $this->flash->success('Votre mot de passe a été modifié');
                $this->redirect('?p=users.login');
            }
        }
        $form = new \Core\Form\Form($this->request->getPost());
        $this->render('users.changePassword', compact('form'));
    }

    /**
     * updateAccount of the current user in session
     */
    public function updateAccount()
    {
        App::getInstance()->setTitle("Modification du compte");
        $user = $this->user->find($this->session->get('auth'));

        if ($this->request->hasPost()) {
            $updateAccountCheckAction = new UpdateAccountCheckAction($this->request, $this->session);
            $errorMessage = $updateAccountCheckAction->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $this->manager->updateAccount();
                $this->redirect('?p=users.account');
            }
        }
        $form = new \Core\Form\Form();
        $this->render('users.updateAccount', compact('form', 'user'));
    }

    /**
     * deleteAccount of the current user in session
     *
     */
    public function deleteAccount()
    {
        App::getInstance()->setTitle("Suppression du compte");

        if ($this->request->hasPost()) {
            $deleteAccountCheckAction = new DeleteAccountCheckAction($this->request, $this->session);
            $errorMessage = $deleteAccountCheckAction->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $this->manager->deleteAccount();
                $this->flash->success('Votre compte a été supprimé');
                $this->redirect('index.php');
            }
        }
        $form = new \Core\Form\Form();
        $this->render('users.deleteAccount', compact('form'));
    }
}
