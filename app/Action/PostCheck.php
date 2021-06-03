<?php

namespace App\Action;

use App\App;
use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class PostCheck extends FormCheck implements FormCheckInterface
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

        if ($this->isEmpty('title') or $this->isEmpty('content') or $this->isEmpty('chapo')) {
            $this->addErrorMessage('Tous les champs doivent être remplis');
        }
    }
}
