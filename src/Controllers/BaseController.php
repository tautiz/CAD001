<?php

namespace Appsas\Controllers;

use Appsas\HtmlRender;
use Appsas\Response;

class BaseController
{
    const TITLE = 'Mano puslapis';

    public function __construct(protected HtmlRender $htmlRender, protected Response $response)
    {
    }

    public function response(mixed $content): Response
    {
        $this->response->content = $content;
        return $this->response;
    }

    public function render(string $template, mixed $content = null): Response
    {
        $this->response->content = $this->htmlRender->renderTemplate($template, $content);
        return $this->response;
    }

    public function redirect(string $url, mixed $content): Response
    {
        $this->response->redirect($url, $content) ;
        return $this->response;
    }
}