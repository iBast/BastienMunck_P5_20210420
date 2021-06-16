<?php

namespace App\Action;


use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class UpdateAdminCheck extends FormCheck implements FormCheckInterface
{

    protected $post;
    protected $session;

    public function __construct($post, $session)
    {

        $this->post = $post;
        $this->session = $session;
        parent::__construct($this->post, $this->session);
    }

    public function check()
    {
        parent::check();
        $user = \App\App::getInstance()->getTable('user')->find($this->post->getPostValue('email'), 'email');
        if ($this->post->getPostValue('email') != $user->email) {
            if ($this->isEmail('email') == false) {
                $this->addErrorMessage('L\'adresse email n\'est pas au bon format');
            }
        }
        if ($this->post->getPostValue('username') != $user->username) {
            if ($this->isUnique('username', 'user') == false) {
                $this->addErrorMessage('Ce nom d\'utilisateur est déjà utilisé');
            }
        }
    }
}
