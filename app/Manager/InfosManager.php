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

    public function __construct($request)
    {
        $this->request = $request;
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
