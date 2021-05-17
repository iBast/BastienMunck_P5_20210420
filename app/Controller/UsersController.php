<?php

namespace App\Controller;

use Core\Auth\DBAuth;
use Core\Http\Request;
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
        $errorMessage = null;
        $successMessage = null;
        $post = new Request($_GET, $_POST);
        $signupCheckAction = new SignupCheckAction($post);

        if ($post->hasPost()) {
            $errorMessage = $signupCheckAction->getErrorMessage();
            if ($errorMessage == null) {
                $pass_hash = password_hash(htmlspecialchars($post->getPostValue('password')), PASSWORD_DEFAULT);
                $result = $this->user->create([
                    'name' => $post->getPostValue('name'),
                    'email' => $post->getPostValue('email'),
                    'password' => $pass_hash
                ]);
                if ($result) {
                    $successMessage = "Le compte a été crée";
                }
            }
        }

        $form = new \Core\HTML\Form($_POST);
        $this->render('users.createAccount', compact('form', 'errorMessage', 'successMessage'));
    }
}
