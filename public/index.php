<?php

const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . 'Core/functions.php';

// Autoload all needed classes
spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    require base_path("{$class}.php");
});

// Include controller based on URI
$router = new \Core\Router('routes.ini');
$router->route(parse_url($_SERVER['REQUEST_URI'])['path']);
