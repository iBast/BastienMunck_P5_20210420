<?php

namespace App\Action;

use App\App;
use Core\Form\FormCheck;
use Core\Form\FormCheckInterface;

class LoginCheckAction extends FormCheck implements FormCheckInterface
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
        $user = App::getInstance()->getTable('user')->find($this->post->getPostValue('username'), 'username');
        if ($this->post->getPostValue('username') != null & $this->post->getPostValue('password') != null) {
            if ($this->isUnique('username', 'user') or $this->isSamePassword($this->post->getPostValue('password'), $user->username) == false) {
                $this->addErrorMessage('Mauvais utilisateur ou mot de passe');
            }
        } else {
            $this->addErrorMessage('Tous les champs n\'ont pas étés remplis');
        }
    }
}
