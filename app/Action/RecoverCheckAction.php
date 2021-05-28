<?php

namespace App\Action;

use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class RecoverCheckAction extends FormCheck implements FormCheckInterface
{

    protected $post;


    public function __construct($post, $session)
    {
        $this->post = $post;
        $this->session = $session;
        parent::__construct($this->post, $this->session);
    }

    public function check()
    {
        parent::check();
        if ($this->isUnique('email', 'user')) {
            $this->addErrorMessage('L\'adresse mail n\'existe pas');
        }
        if ($this->isEmail('email') == false) {
            $this->addErrorMessage('le format de l\'adresse email n\'est pas valide');
        }
    }
}
