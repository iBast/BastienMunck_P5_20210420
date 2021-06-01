<?php

namespace App\Action;

use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class SignupCheckAction extends FormCheck implements FormCheckInterface
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
        if ($this->isEmpty('username')) {
            $this->addErrorMessage('Veuillez saisir un nom');
        }
        if ($this->isEmpty('email')) {
            $this->addErrorMessage('Veuillez saisir un email');
        }
        if ($this->isEmail('email') == false) {
            $this->addErrorMessage('Votre adresse email ne respecte pas le bon format');
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
        if ($this->isUnique('username', 'user') == false) {
            $this->addErrorMessage("Ce nom d'utilisateur est déjà utilisé");
        }
    }
}
