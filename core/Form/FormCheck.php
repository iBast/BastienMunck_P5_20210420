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

    /**
     * check a form using existing rules
     *
     * @return mixed
     */
    public function check()
    {
        if ($this->isSame($this->post->getPostValue('token'), $this->session->get($this->post->getPostValue('tokenName'))) == false) {
            return $this->addErrorMessage("Le formulaire ne correspond pas à celui posté");
        }
    }

    /**
     * isError set error
     *
     * @return bool
     */
    public  function isError(): bool
    {
        return $this->error;
    }

    /**
     * getErrorMessage
     *
     * @return string
     */
    public  function getErrorMessage(): string
    {
        return $this->errorMessage;
    }


    /**
     * addErrorMessage
     *
     * @param  string $message
     * @return void
     */
    protected function addErrorMessage($message): void
    {
        $this->error = true;
        $separator = '<br/>';
        $this->errorMessage =  $this->errorMessage . $separator . htmlspecialchars($message);
    }

    /**
     * isEmpty check if a key is empty
     *
     * @param  mixed $key
     * @return bool
     */
    protected function isEmpty($key): bool
    {
        if (empty($this->post->getPostValue($key))) {
            return true;
        }
        return false;
    }

    /**
     * isSame check if 2 values are the same
     *
     * @param  mixed $value1
     * @param  mixed $value2
     * @return bool
     */
    protected function isSame($value1, $value2): bool
    {
        if ($value1 === $value2) {
            return true;
        }
        return false;
    }

    /**
     * isSamePassword check if a password match the passord from a username in DB
     *
     * @param  string $password
     * @param  string $username
     * @return bool
     */
    protected function isSamePassword($password, $username): bool
    {
        $user = App::getInstance()->getTable('user')->find($username, 'username');
        if (password_verify($password, $user->password)) {
            return true;
        }
        return false;
    }

    /**
     * isUnique check if a key exist in DB
     *
     * @param  string $key
     * @param  string $table
     * @return bool
     */
    protected function isUnique(string $key, string $table): bool
    {
        $check = App::getInstance()->getTable($table)->find($this->post->getPostValue($key), $key);
        if ($check != null) {
            return false;
        }
        return true;
    }

    /**
     * isEmail check if a key is an email
     *
     * @param  string $key
     * @return bool
     */
    protected function isEmail(string $key): bool
    {
        if (filter_var($this->post->getPostValue($key), FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}
