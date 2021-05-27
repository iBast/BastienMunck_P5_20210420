<?php

namespace App\Controller;

use App\App;
use Core\Controller\Controller;


class AppController extends Controller
{
    protected $template = 'default';
    protected $request;
    protected $session;
    protected $flash;
    protected $dbAuth;

    public function __construct($session, $flash, $request, $dbAuth)
    {
        $this->viewPath = '../app/Views/';
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
