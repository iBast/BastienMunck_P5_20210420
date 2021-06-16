<?php

namespace App\Action;

use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class DeleteComCheck extends FormCheck implements FormCheckInterface
{

    protected $comment;
    protected $user;

    public function __construct($post, $session, $comment, $user)
    {
        $this->comment = $comment;
        $this->user = $user;
        parent::__construct($post, $session);
    }

    public function check()
    {
        if ($this->isSame($this->comment->author, $this->user) == false) {
            $this->addErrorMessage('Ce commentaire ne vous appartient pas');
        }
    }
}
