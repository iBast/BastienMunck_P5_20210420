<?php

namespace App\Controller;

use App\App;
use Core\Http\Request;
use Core\Http\Session;
use Core\Controller\Controller;
use Core\Http\FlashMessage;

class AppController extends Controller
{
    protected $template = 'default';
    protected $request;
    protected $session;
    protected $flash;

    public function __construct()
    {
        $this->viewPath = '../app/Views/';
        $this->request = new Request($_GET, $_POST);
        $this->session = new Session;
        $this->flash = new FlashMessage($this->session);
    }
    public function loadModel($model_name)
    {
        $this->$model_name = App::getInstance()->getTable($model_name);
    }
}
