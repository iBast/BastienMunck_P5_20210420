<?php

namespace App\Controller;

use App;
use Core\Controller\Controller;


class AppController extends Controller
{
    protected $template = 'default';

    public function __construct()
    {
        $this->viewPath = '../app/Views/';
    }
    public function loadModel($model_name)
    {
        $this->$model_name = App\App::getInstance()->getTable(ucfirst($model_name));
    }
}
