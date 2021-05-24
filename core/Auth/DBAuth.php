<?php

namespace Core\Auth;

use Core\Database\Database;
use Core\Http\Session;

/**
 * Class DBAuth
 * 
 * Use to create users sessions 
 */
class DBAuth
{
    public function __construct(Database $database, Session $session)
    {
        $this->database = $database;
        $this->session = $session;
    }

    public function getUserId()
    {
        if ($this->logged()) {
            return $this->session->get('auth');
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

        $user = $this->database->prepare('SELECT * FROM users WHERE username = ?', [$username], NULL, true);
        if ($user) {
            $this->session->set('auth', $user->id);
            return true;
        }

        return false;
    }

    public function logged()
    {
        if ($this->session->get('auth') != null) {
            return true;
        }
        return false;
    }
}
