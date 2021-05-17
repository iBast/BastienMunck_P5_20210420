<?php

namespace App\Controller;

use Core\Auth\DBAuth;
use Core\Http\Request;
use App\Action\SignupCheckAction;
use Core\Http\Session;

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
                $result = $this->user->create([
                    'name' => htmlspecialchars($post->getPostValue('name')),
                    'email' => htmlspecialchars($post->getPostValue('email')),
                    'password' => $pass_hash,
                    'token' => $token
                ]);
                if ($result) {
                    $successMessage = "Le compte a été crée";
                }
            }
        }

        $form = new \Core\HTML\Form($_POST);
        $this->render('users.createAccount', compact('form', 'errorMessage', 'successMessage', 'session', 'token'));
        $session->set('token', $token);
    }
}
