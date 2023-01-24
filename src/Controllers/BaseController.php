<?php

namespace Appsas\Controllers;

use Appsas\HtmlRender;
use Appsas\Response;

class BaseController
{
    protected Response $response;

    const TITLE = 'Mano puslapis';

    public function __construct()
    {
        $this->response = new Response(null);
    }

    public function response(mixed $content): Response
    {
        $this->response->content = $content;
        return $this->response;
    }

    public function render(string $template, mixed $content = null): Response
    {
        $this->response->content = HtmlRender::renderTemplate($template, $content);
        return $this->response;
    }

    public function redirect(string $url, mixed $content): Response
    {
        $this->response->redirect($url, $content) ;
        return $this->response;
    }
}