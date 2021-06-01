<?php

namespace App\Controller\Admin;

use App\App;
use Core\Auth\DBAuth;
use App\Controller\AppController;

class AdminController extends AppController
{
    protected $template = 'admin';
    protected $request;
    protected $session;
    protected $flash;
    protected $dbAuth;

    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($session, $flash, $request, $dbAuth);
        //Auth 
        $app = App::getInstance();
        $auth = new DBAuth($app->getDb(), $session);
        if (!$auth->logged()) {
            $flash->danger('Vous devez être connecté pour accèder à cette page');
            $this->forbidden();
        }
        if ($session->get('role') < 2) {
            $flash->danger('Votre statut ne vous permet pas d\'accèder à cette page');
            $this->forbidden();
        }
    }
}
