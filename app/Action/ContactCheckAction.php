<?php

namespace App\Action;

use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class ContactCheckAction extends FormCheck implements FormCheckInterface
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
        if ($this->isEmpty('name') or $this->isEmpty('email') or $this->isEmpty('message')) {
            return $this->addErrorMessage('veuillez remplir tous les champs');
        }
    }
}
