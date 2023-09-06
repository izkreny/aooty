<?php

    const BASE_PATH = __DIR__ . '/../';

    function base_path($path)
    {
        return BASE_PATH . $path;
    }

    spl_autoload_register(function ($class) {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        require base_path("{$class}.php");
    });

    $uri = parse_url($_SERVER['REQUEST_URI']); //['path'];


    echo '<pre>';
    var_dump($uri);
    var_dump($_GET);
    var_dump($_SERVER);
    echo '</pre>';
