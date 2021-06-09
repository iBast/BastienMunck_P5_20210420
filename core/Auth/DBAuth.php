<?php

namespace Core\Auth;

use Core\Database\Database;
use Core\Http\Session;
use Core\Http\FlashMessage;

/**
 * Class DBAuth
 * 
 * Use to create users sessions 
 */
class DBAuth
{
    private $flash;

    public function __construct(Database $database, Session $session)
    {
        $this->database = $database;
        $this->session = $session;
        $this->flash = new FlashMessage($this->session);
    }

    /**
     * getUserId
     *
     * Return userID if connected
     * @return mixed
     */
    public function getUserId()
    {
        if ($this->logged()) {
            return $this->session->get('auth');
        }

        return false;
    }

    /**
     * Log user in session
     * 
     * @param $username
     * @return boolean
     */
    public function login($username): bool
    {

        $user = $this->database->prepare('SELECT * FROM users WHERE username = ?', [$username], NULL, true);
        if ($user->passwordLock == 0) {
            $this->session->set('auth', $user->id);
            $this->session->set('role', $user->role);
            $this->flash->success("Vous êtes connecté");
            return true;
        }
        $this->flash->danger('Votre mot de passe doit être modifé');
    }

    /**
     * logged
     *
     * @return void
     */
    public function logged()
    {
        return $this->session->get('auth') != null;
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        if ($this->session->get('auth') != null) {
            $this->flash->success('Vous avez été déconnecté');
            return $this->session->delete('auth');
        }
        $this->flash->danger('Vous devez être connecté pour pouvoir vous déconnecter :)');
    }
}
