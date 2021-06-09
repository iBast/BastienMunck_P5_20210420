<?php

namespace App\Manager;

use Core\Http\Request;
use App\Action\UserMail;

/**
 * InfosManager
 * 
 * process the logic for the controller
 */
class InfosManager
{
    private $request;
    private $session;
    private $flash;

    public function __construct($request, $session, $flash)
    {
        $this->request = $request;
        $this->session = $session;
        $this->flash = $flash;
    }

    public function send()
    {
        $username = $this->request->getPostValue('name');
        $email = $this->request->getPostValue('email', Request::TYPE_MAIL);
        $message = $this->request->getPostValue('message');
        $mail = new UserMail;
        $mail->contactMail($email, $username, $message);

        return $mail;
    }
}
