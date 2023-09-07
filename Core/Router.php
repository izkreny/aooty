<?php

    namespace Core;

    class Router
    {
        private $routes = [];

        public function __construct($routes)
        {
            $config = new \Core\Config($routes);
            $this->routes = $config->getAll('routes');
        }

        public function route($uri)
        {
            foreach ($this->routes as $path => $controller) {
                if ($uri === $path) {
                    return require base_path($controller);
                }
            }
        }
    }
