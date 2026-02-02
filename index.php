<?php

spl_autoload_register(function ($class) {
    $directories = ['controllers/', 'models/', 'utils/', 'traits/', 'interfaces/'];
    foreach ($directories as $directory) {
        $file = __DIR__ . '/' . $directory . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

session_start();

$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'AuthController';
$actionName = $_GET['action'] ?? 'loginForm';

if (class_exists($controllerName)) {
    $controller = new $controllerName();
    if (method_exists($controller, $actionName)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->$actionName($_POST);
        } else {
            $controller->$actionName();
        }
    } else {
        echo "Error: The action '$actionName' does not exist.";
    }
} else {
    echo "Error: The controller '$controllerName' was not found.";
}