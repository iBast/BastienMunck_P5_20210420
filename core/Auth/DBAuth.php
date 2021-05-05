<?php

namespace Core\Auth;

use Core\Database\Database;

/**
 * Class DBAuth
 * 
 * Use to create users sessions 
 */
class DBAuth
{
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getUserId()
    {
        if ($this->logged()) {
            return $_SESSION['auth'];
        }

        return false;
    }

    /**
     * @param $username
     * @param $password
     * @return boolean
     */
    public function login($username, $password)
    {

        $user = $this->db->prepare('SELECT * FROM users WHERE username = ?', [$username], NULL, true);
        if ($user) {
            if ($user->password === sha1($password)) {
                $_SESSION['auth'] = $user->id;
                return true;
            }
        }

        return false;
    }

    public function logged()
    {
        return isset($_SESSION['auth']);
    }
}
