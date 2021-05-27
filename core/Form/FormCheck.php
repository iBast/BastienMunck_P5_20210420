<?php

namespace Core\Form;

use App\App;

/**
 * FormCheck
 * 
 * Rules to check form, 
 */
abstract class FormCheck implements FormCheckInterface
{

    protected $post;
    protected $session;
    protected $errorMessage;
    protected $error;

    public function __construct($post, $session)
    {
        $this->post = $post;
        $this->session = $session;
        $this->errorMessage = "";
        $this->error = false;
        $this->check();
    }

    public function check()
    {
        if ($this->isSame($this->post->getPostValue('token'), $this->session->get($this->post->getPostValue('tokenName'))) == false) {
            return $this->addErrorMessage("Le formulaire ne correspond pas à celui posté");
        }
    }

    public  function isError(): bool
    {
        return $this->error;
    }

    public  function getErrorMessage(): string
    {
        return $this->errorMessage;
    }


    protected function addErrorMessage($message): void
    {
        $this->error = true;
        $separator = '<br/>';
        $this->errorMessage =  $this->errorMessage . $separator . htmlspecialchars($message);
    }

    protected function isEmpty($key): bool
    {
        if (empty($this->post->getPostValue($key))) {
            return true;
        }
        return false;
    }

    protected function isSame($value1, $value2): bool
    {
        if ($value1 === $value2) {
            return true;
        }
        return false;
    }

    protected function isSamePassword($password, $username): bool
    {
        $user = App::getInstance()->getTable('user')->find($username, 'username');
        if (password_verify($password, $user->password)) {
            return true;
        }
        return false;
    }

    protected function isUnique(string $key, string $table): bool
    {
        $check = App::getInstance()->getTable($table)->find($this->post->getPostValue($key), $key);
        if ($check != null) {
            return false;
        }
        return true;
    }

    protected function isEmail(string $key): bool
    {
        if (filter_var($this->post->getPostValue($key), FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}
