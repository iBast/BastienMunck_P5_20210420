<?php

namespace Core\Form;

use App\App;

abstract class FormCheck
{

    private $post;
    private $errorMessage;
    private $error;

    public function __construct($post)
    {
        $this->post = $post;
        $this->errorMessage = "";
        $this->error = false;
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

    protected function isUnique(string $key, string $table)
    {
        $user = App::getInstance()->getTable($table)->find($this->post->getPostValue($key), $key);
        if ($user != null) {
            return false;
        }
        return true;
    }
}
