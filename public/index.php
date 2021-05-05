<?php

require '../app/App.php';
App::load();



if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {
    $page = 'posts.index';
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
