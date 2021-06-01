<?php

namespace App;

use Core\Config;
use Core\Database\MysqlDatabase;

/**
 * Class App
 * 
 * Set up the app
 */
class App
{
    public $title = 'Bastien Munck - Développeur PHP';
    private $db_instance;
    private static $_instance;

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    /**
     * Method getTable
     * 
     * Pass the table name extends from core/Table.php
     */
    public function getTable($name)
    {
        $class_name = '\\App\\Table\\' . ucfirst($name) . 'Table';
        return new $class_name($this->getDb());
    }

    /**
     * Method getDb
     * 
     * use the config file to connect to the database
     */
    public function getDb()
    {
        $config = Config::getInstance(ROOT . '/config/config.php');
        if ($this->db_instance === null) {
            $this->db_instance = new MysqlDatabase($config->get('db_name'), $config->get('db_user'), $config->get('db_pass'), $config->get('db_host'));
        }
        return $this->db_instance;
    }


    public function setTitle($title)
    {
        $this->title = $title;
    }
    /**
     * Method run
     * 
     * 
     */
    public static function run()
    {
        session_start();
    }
}
