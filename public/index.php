<?php

use Core\Http\Session;
use Core\Auth\DBAuth;
use Core\Http\Request;
use Core\Http\FlashMessage;

try {
    ini_set('session.cookie_secure', 1);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    define('ROOT', dirname(__DIR__));
    require_once ROOT . '/vendor/autoload.php';
    $session = new Session;
    $flash = new FlashMessage($session);
    $request = new Request($_GET, $_POST);
    $app = new App\App;
    $dbAuth = new DBAuth($app->getInstance()->getDb(), $session);
    $app->run();


    if ($request->getGetValue('p') !== null) {
        $page = $request->getGetValue('p');
    } else {
        $page = 'infos.home';
    }

    $page = explode('.', $page);
    $action = $page[1];

    if ($page[0] == 'admin') {
        $controller = '\App\Controller\Admin\\' . ucfirst($page[1]) . 'Controller';
        $action = $page[2];
    } else {
        $controller = '\App\Controller\\' . ucfirst($page[0]) . 'Controller';
        $action = $page[1];
    }

    if (class_exists($controller)) {
        $controller = new $controller($session, $flash, $request, $dbAuth);
    }
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        $controller = new \App\Controller\InfosController($session, $flash, $request, $dbAuth);
        $controller->notFound();
    }
} catch (Exception $e) {
    $errors = $e->getMessage();
    $controller->$action();
}
