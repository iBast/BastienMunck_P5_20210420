<?php

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
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    /**
     * Method getTable
     * 
     * Pass the table name to core/Table.php
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
        if (is_null($this->db_instance)) {
            $this->db_instance = new MysqlDatabase($config->get('db_name'), $config->get('db_user'), $config->get('db_pass'), $config->get('db_host'));
        }
        return $this->db_instance;
    }

    /**
     * Method load
     * 
     * require the app & core autoloaders
     */
    public static function load()
    {
        session_start();
        require ROOT . '/app/Autoloader.php';
        \App\Autoloader::register();
        require ROOT . '/core/Autoloader.php';
        \Core\Autoloader::register();
    }
}
