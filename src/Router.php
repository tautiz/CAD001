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

    public function get(string $url, array $controllerData): void
    {
        $this->addRoute('GET', $url, $controllerData);
    }

    public function post(string $url, array $controllerData): void
    {
        $this->addRoute('POST', $url, $controllerData);
    }

    /**
     * @throws PageNotFoundException
     */
    public function run(): void
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
            if($response instanceof Response && $response->redirect) {
                header('location: ' . $response->redirectUrl);
                $response->redirect = false;
                exit;
            }
        } else {
            throw new PageNotFoundException("Adresas: [$method] /$url nerastas");
        }

        if (!$response instanceof Response) {
            throw new \Exception('Controllerio metodas turi grąžinti Response objektą');
        }
        $response = $response->content;

        // Iš kontrolerio funkcijos gautą atsakymą talpiname į main.html layout failą
        $failoSistema = new FS('../src/html/layout/main.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        $title = $controller::TITLE;
        $failoTurinys = str_replace("{{title}}", $title, $failoTurinys);
        $failoTurinys = str_replace("{{content}}", $response, $failoTurinys);

        // Išvalomi Templeituose likę {{}} tagai
        preg_match_all('/{{(.*?)}}/', $failoTurinys, $matches);
        foreach ($matches[0] as $key) {
            $failoTurinys = str_replace($key, '', $failoTurinys);
        }

        echo $failoTurinys;
    }
}