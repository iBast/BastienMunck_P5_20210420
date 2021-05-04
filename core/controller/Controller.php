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
        header('HTTP/1.0 404 Not Found');
        die('Page introuvable');
    }

    protected function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        die('Acces interdit');
    }
}
