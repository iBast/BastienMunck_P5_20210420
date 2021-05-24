<?php

namespace App\Action;

use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class LoginCheckAction extends FormCheck implements FormCheckInterface
{

    private $post;
    private $session;
    private $username;
    private $password;

    public function __construct($post, $session)
    {
        parent::__construct($post);
        $this->post = $post;
        $this->session = $session;
        $this->check();
    }

    public function check()
    {
        if ($this->post->getPostValue('username') != null & $this->post->getPostValue('password') != null) {
            if ($this->isUnique('username', 'user') & $this->isSamePassword($this->post->getPostValue('password'), $this->password) == false) {
                $this->addErrorMessage('Mauvais utilisateur ou mot de passe');
            }
        } else {
            $this->addErrorMessage('Tous les champs n\'ont pas étés remplis');
        }
    }
}
