<?php

namespace App\Action;

use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class SignupCheckAction extends FormCheck implements FormCheckInterface
{

    private $post;
    private $session;

    public function __construct($post, $session)
    {
        parent::__construct($post);
        $this->post = $post;
        $this->session = $session;
        $this->check();
    }


    public function check()
    {
        if ($this->isSame($this->post->getPostValue('token'), $this->session->get('token')) == false) {
            $this->addErrorMessage("Le formulaire ne correspond pas à celui posté");
        }
        if ($this->isEmpty('username')) {
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
        if ($this->isUnique('username', 'user') == false) {
            $this->addErrorMessage("Ce nom d'utilisateur est déjà utilisé");
        }
    }
}
