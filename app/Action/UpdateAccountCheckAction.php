<?php

namespace App\Action;

use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class UpdateAccountCheckAction extends FormCheck implements FormCheckInterface
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
        if ($this->post->getPostValue('email') != '') {
            if ($this->isEmail('email') == false) {
                $this->addErrorMessage('L\'adresse email n\'est pas au bon format');
            }
            if ($this->isSame($this->post->getPostValue('email'), $user->email)) {
                $this->addErrorMessage('L\'adresse email est identique à l\'actuelle');
            }
            if ($this->isUnique('email', 'user') == false) {
                $this->addErrorMessage('Cette adresse email est déjà utilisée');
            }
        }
        if ($this->post->getPostValue('username') != '') {
            if ($this->isSame($this->post->getPostValue('username'), $user->username)) {
                $this->addErrorMessage('Le nom d\'utilisateur est identique à l\'actuel');
            }
            if ($this->isUnique('username', 'user') == false) {
                $this->addErrorMessage('Ce nom d\'utilisateur est déjà utilisé');
            }
        }
    }
}
