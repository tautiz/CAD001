<?php

namespace Appsas;

use Appsas\Exceptions\PageNotFoundException;
use Appsas\Request;
use Exception;

class Router
{
    /**
     * @param Output $output
     * @param array $routes
     */
    public function __construct(protected Output $output, protected HtmlRender $render, protected array $routes = [])
    {
    }

    /**
     * Prideda Routus į $this->routes masyvą
     *
     * @param string $method
     * @param string $url
     * @param array $controllerData
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
            $request = new Request();
            $response = $controller->$action($request);

            if($response instanceof Response && $response->redirect) {
                header('location: ' . $response->redirectUrl);
                $response->redirect = false;
                exit;
            }

            if (!$response instanceof Response) {
                throw new Exception("Controllerio $controller metodas '$action' turi grąžinti Response objektą");
            }

            // Iškviečiamas Render klasės objektas ir jo metodas setContent()
            $this->render->setContent(
                [
                    'content' => $response->content,
                    'title' => $response->params['title'] ?? 'Mano svetaine',
                    'message' => $request->get('message')
                ]
            );

            // Spausdinam viska kas buvo 'Storinta' Output klaseje
            $this->output->print();
        } else {
            throw new PageNotFoundException("Adresas: [$method] /$url nerastas");
        }
    }
}