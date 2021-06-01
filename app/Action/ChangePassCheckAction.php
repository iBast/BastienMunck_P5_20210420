<?php

namespace App\Action;

use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class ChangePassCheckAction extends FormCheck implements FormCheckInterface
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
        if ($this->isEmpty('current-password') or $this->isEmpty('password') or $this->isEmpty('password-confirm') or $this->isEmpty('email')) {
            return $this->addErrorMessage('veuillez remplir tous les champs');
        }
        $user = \App\App::getInstance()->getTable('user')->find($this->post->getPostValue('email'), 'email');
        if ($this->isUnique('email', 'user') or  $this->isSamePassword($this->post->getPostValue('current-password'), $user->username) == false) {
            $this->addErrorMessage('Mauvais utilisateur ou mot de passe');
        }
        if ($this->isSame($this->post->getPostValue('password'), $this->post->getPostValue('password-confirm')) == false) {
            $this->addErrorMessage('Les nouveaux mots de passe ne correspondent pas');
        }
    }
}
