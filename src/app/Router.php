<?php

namespace App;

use App\Controllers\HomeController;

class Router
{
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method) {

        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
    }

    public function get($route, $controller, $action) {
        $this->addRoute($route, $controller, $action, "GET");
    }

    public function post($route, $controller, $action) {
        $this->addRoute($route, $controller, $action, "POST");
    }

    public function dispatch() {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method =  $_SERVER['REQUEST_METHOD'];

        $fileTypes = ['js', 'css', 'jpg', 'png', 'gif'];

        $fileType = pathinfo($uri, PATHINFO_EXTENSION);

        if (in_array($fileType, $fileTypes)) {
            readfile($_SERVER['DOCUMENT_ROOT'] . $uri);
            return;
        }

        if (array_key_exists($uri, $this->routes[$method])) {
            $controller = $this->routes[$method][$uri]['controller'];
            $action = $this->routes[$method][$uri]['action'];

            $controller = new $controller();
            $controller->$action();
        } else {
            $controller = new HomeController();
            $controller->notFound();
            return;
        }
    }
}