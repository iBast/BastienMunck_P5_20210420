<?php

namespace App\Controller;


use Core\Http\Request;
use App\Action\SignupCheckAction;
use App\Action\UserMail;
use App\Table\UserTable;
use Core\Http\Session;
use App\App;


class UsersController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('user');
    }
    public function createAccount()
    {
        $post = new Request($_GET, $_POST);
        $errorMessage = null;
        $successMessage = null;
        $session = new Session;
        $token = bin2hex(random_bytes(16));

        $signupCheckAction = new SignupCheckAction($post, $session);
        if ($post->hasPost()) {

            $errorMessage = $signupCheckAction->getErrorMessage();

            if ($errorMessage == null) {
                $pass_hash = password_hash(htmlspecialchars($post->getPostValue('password')), PASSWORD_DEFAULT);
                $user = [
                    'name' => htmlspecialchars($post->getPostValue('name')),
                    'email' => htmlspecialchars($post->getPostValue('email')),
                    'password' => $pass_hash,
                    'token' => $token
                ];
                $result = $this->user->create($user);
                if ($result) {
                    $successMessage = "Le compte a été crée";
                    $mail = new UserMail;
                    $mail->signupMail($user['email'], $user['name'], $user['token']);
                    return $this->render('users.login', compact('successMessage'));
                }
            }
        }

        $form = new \Core\HTML\Form($_POST);
        $this->render('users.createAccount', compact('form', 'errorMessage', 'successMessage', 'session', 'token'));
        $session->set('token', $token);
    }

    public function login()
    {
        $this->render('users.login');
    }

    public function verifyToken()
    {
        $errorMessage = null;
        $get = new Request($_GET, $_POST);
        if ($get->getGetValue('t') == null & $get->getGetValue('username') == null) {

            $errorMessage = "Aucune clé de Vérification n'a été envoyée";
        }
        $user = $this->user->find($get->getGetValue('username'), 'name');
        if ($user['token'] === $get->getGetValue('t')) {
            $this->user->update($user['id'], [
                'verifiedAt' => date("Y-m-d H:i:s"),
                'token' => null
            ]);
            $successMessage = "Le compte a bien été validé. Veuillez vous connecter";
            return $this->render('users.login', compact('successMessage'));
        }
        $errorMessage = "Aucune action a effectuer";
        $this->render('users.verifyToken', compact('errorMessage'));
    }
}
