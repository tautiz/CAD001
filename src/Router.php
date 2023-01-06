<?php

namespace Appsas;

use Appsas\Exceptions\PageNotFoundException;

class Router
{
    private array $routes = [];

    public function addRoute(string $method, string $url, array $controllerData): void
    {
        $this->routes[$method][$url] = $controllerData;
    }

    public function run():void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url)[0];
        $url = rtrim($url, '/'); // /admin/ => /admin
        $url = ltrim($url, '/'); // admin/ -> admin

        if (isset($this->routes[$method][$url])) {
            $controllerData = $this->routes[$method][$url];
            $controller = $controllerData[0];
            $action = $controllerData[1];
            $response = $controller->$action();
        } else {
            throw new PageNotFoundException('404');
        }

        echo $response;
    }
}