<?php

namespace App\Action;

use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class CommentCheck extends FormCheck implements FormCheckInterface
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

        if ($this->isEmpty('content')) {
            $this->addErrorMessage('Tous les champs doivent être remplis');
        }
        if ($this->isEmpty('post')) {
            $this->addErrorMessage('Pas d\'article lié pour ce commentaire');
        }
    }
}
