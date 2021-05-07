<?php

namespace Core\Controller;

/**
 * Class Controller
 * 
 * Core controler, render content from child controllers
 */
class Controller
{
    protected $viewPath;
    protected $template;

    protected function render($view, $variables = [])
    {
        ob_start();
        extract($variables);
        require($this->viewPath . str_replace('.', '/', $view) . '.php');
        $content = ob_get_clean();
        require($this->viewPath . 'templates/' . $this->template . '.php');
    }
    public function NotFound()
    {
        header('Location:./index.php?p=infos.notfound');
        exit;
    }

    protected function forbidden()
    {
        header('Location:./index.php?p=infos.forbidden');
        exit;
    }
}
