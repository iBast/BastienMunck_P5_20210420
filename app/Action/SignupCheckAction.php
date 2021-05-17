<?php

namespace App\Action;

use App\App;
use App\Action\CheckAction;


class SignupCheckAction extends CheckAction
{

    private $post;

    public function __construct($post)
    {
        parent::__construct($post);
        $this->post = $post;
        $this->check();
    }


    protected function check()
    {

        if ($this->isEmpty('name')) {
            $this->addErrorMessage('Veuillez saisir un nom');
        }

        if ($this->isEmpty('email')) {
            $this->addErrorMessage('Veuillez saisir un email');
        }

        if ($this->isEmpty('password')) {
            $this->addErrorMessage('Veuillez saisir un mot de passe');
        }

        if ($this->isEmpty('confirm_password')) {
            $this->addErrorMessage('Veuillez confirmer le mot de passe');
        }
        if ($this->isSame($this->post->getPostValue('password'), $this->post->getPostValue('confirm_password')) == false) {
            $this->addErrorMessage('Les mots de passe ne correspondent pas');
        }
        if ($this->isUnique('email', 'user') == false) {
            $this->addErrorMessage("L'email est déjà utilisé, merci de vous connecter ou de choisir un autre email");
        }

        if ($this->isUnique('name', 'user') == false) {
            $this->addErrorMessage("Ce nom d'utilisateur est déjà utilisé");
        }
    }
}
