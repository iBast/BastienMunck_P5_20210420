<?php

namespace Core;

/**
 * Class Config
 * 
 * use the arrray in file config/config.php
 */
class Config
{
    private $settings = [];

    private static $_instance;

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new Config();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        $this->settings = require '../config/config.php';
    }

    public function get($key)
    {
        if (!isset($this->settings[$key])) {
            return null;
        }
        return $this->settings[$key];
    }
}
