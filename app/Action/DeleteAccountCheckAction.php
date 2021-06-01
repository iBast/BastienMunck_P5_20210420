<?php

namespace App\Action;

use App\App;
use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class DeleteAccountCheckAction extends FormCheck implements FormCheckInterface
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
        $user = \App\App::getInstance()->getTable('user')->find($this->session->get('auth'));

        if ($this->isEmpty('password')) {
            $this->addErrorMessage('Veuillez saisir un mot de passe');
        }
        if ($this->isSamePassword($this->post->getPostValue('password'), $user->username) == false) {
            $this->addErrorMessage('Le mot de passe ne correspond pas');
        }
    }
}
