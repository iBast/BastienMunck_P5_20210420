<?php

use Core\Http\Request;

try {
    require_once '../vendor/autoload.php';
    $app = new App\App;
    $app->run();


    $request = new Request($_GET, $_POST);
    if ($request->getGetValue('p') !== null) {
        $page = $request->getGetValue('p');
    } else {
        $page = 'users.createAccount';
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


    $controller = new $controller();
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        $controller = new \Core\Controller\Controller;
        $controller->NotFound();
    }
} catch (Exception $e) {
    $errors = $e->getMessage();
    $controller->$action();
}
