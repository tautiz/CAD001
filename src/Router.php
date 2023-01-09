<?php

namespace Appsas;

use Appsas\Exceptions\PageNotFoundException;

class Router
{
    private array $routes = [];

    /**
     * Prideda Routus į $this->routes masyvą
     *
     * @param string $path
     * @param string $controller
     * @param string $method
     */
    public function addRoute(string $method, string $url, array $controllerData): void
    {
        $this->routes[$method][$url] = $controllerData;
    }

    /**
     * @throws PageNotFoundException
     */
    public function run():void
    {
        // Iš $_SERVER paimame užklausos metodą ir URL adresą
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url)[0];
        $url = rtrim($url, '/');
        $url = ltrim($url, '/');

        // Tikriname ar yra toks URL adresas ir metodas sukurtas mūsų $this->routes masyve
        if (isset($this->routes[$method][$url])) {
            // Iš $this->routes masyvo paimame controller klasės pavadinimą ir metodą
            $controllerData = $this->routes[$method][$url];
            $controller = $controllerData[0];
            $action = $controllerData[1];
            // Iškviečiamas kontrolierio ($controller) objektas ir kviečiamas jo metodas ($action)
            $response = $controller->$action();
        } else {
            throw new PageNotFoundException("Adresas: [$method] /$url nerastas");
        }

        // Spausinam $response kuris gautas iš Controllerio atitinkamo metodo
        echo $response;
    }
}