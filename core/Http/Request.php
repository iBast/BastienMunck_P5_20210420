<?php

namespace Core\Http;

/**
 * Request
 * 
 * Get and securise superglobals GET and POST
 */
class Request
{
    private $_get;
    private $_post;

    public const TYPE_STRING = '0';
    public const TYPE_MAIL = '1';
    public const TYPE_INT = '2';
    public const TYPE_BOOLEAN = '3';
    public const TYPE_ARRAY = '4';
    public const TYPE_HTMLENTITY = '5';

    public function __construct($get = null, $post = null)
    {
        $this->_get = isset($get) ? $get : null;
        $this->_post = isset($post) ? $post : null;
    }
    public function getGetValue($key, $type = self::TYPE_STRING)
    {
        return isset($this->_get[$key]) ? $this->securise($this->_get[$key], $type) : null;
    }
    public function hasGetValue($key): bool
    {
        return isset($this->_get[$key]);
    }

    public function getPostValue($key, $type = self::TYPE_STRING)
    {
        return isset($this->_post[$key]) ? $this->securise($this->_post[$key], $type) : null;
    }
    public function hasPost()
    {
        return !empty($this->_post);
    }
    public function hasPostValue($key): bool
    {
        return isset($this->_post[$key]);
    }
    public function getPost()
    {
        return $this->_post;
    }
    public function unsetPost($key)
    {
        unset($this->_post[$key]);
    }

    private function securise($data, $type = self::TYPE_STRING)
    {
        switch ($type) {
            case self::TYPE_STRING:
                $retour = (string)filter_var($data);
                break;
            case self::TYPE_ARRAY:
                $retour = is_array($data) ? $data : false;
                break;
            case self::TYPE_INT:
                $retour = filter_var($data, FILTER_VALIDATE_INT);
                break;
            case self::TYPE_MAIL:
                $retour = filter_var($data, FILTER_SANITIZE_EMAIL);
                $retour = filter_var($retour, FILTER_VALIDATE_EMAIL);
                break;
            case self::TYPE_BOOLEAN:
                $retour = filter_var($data, FILTER_VALIDATE_BOOLEAN);
                break;
            default:
                $retour = htmlentities($data);
                break;
        }
        return $retour;
    }
}
