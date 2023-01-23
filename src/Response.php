<?php

namespace Appsas;

class Response
{
    public string $content;
    public bool $redirect = false;
    public string $redirectUrl = '';

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function redirect(string $url): void
    {
        $this->redirect = true;
        $this->redirectUrl = $url;
    }
}