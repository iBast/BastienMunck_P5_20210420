<?php

namespace Core\Controller;

/**
 * Class Controller
 * 
 * Core controler
 */
class Controller
{
    protected $viewPath;
    protected $template;


    /**
     * render
     *
     * Generate view for the user
     * 
     * @param  string $view
     * @param  array $variables
     * @return void
     */
    protected function render(string $view, array $variables = []): void
    {
        ob_start();
        extract($variables);
        require($this->viewPath . str_replace('.', '/', $view) . '.php');
        $content = ob_get_clean();
        require($this->viewPath . 'templates/' . $this->template . '.php');
    }

    /**
     * NotFound
     *
     * redirect user when a page hasn't been found
     */
    public function NotFound()
    {
        header('Location:./index.php?p=infos.notfound');
        exit;
    }

    /**
     * forbidden
     *
     * redirect user when a page is not allowed to him
     */
    protected function forbidden()
    {
        header('Location:./index.php?p=infos.forbidden');
        exit;
    }

    /**
     * redirect
     * 
     * redirect user to a given url
     *
     * @param  string $url
     * @return void
     */
    protected function redirect($url): void
    {
        header("Location: " . $url);
        exit;
    }
}
