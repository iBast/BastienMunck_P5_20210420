<?php

namespace App\Controller;

use App\App;
use Core\Controller\Controller;


/**
 * AppController
 * 
 * Extends the core controller
 */
class AppController extends Controller
{
    protected $template = 'default';

    public function __construct($session, $flash, $request, $dbAuth)
    {
        $this->viewPath = '../App/Views/';
        $this->request = $request;
        $this->session = $session;
        $this->flash = $flash;
        $this->dbAuth = $dbAuth;
    }
    public function loadModel($model_name)
    {
        $this->$model_name = App::getInstance()->getTable($model_name);
    }
}
