<?php

namespace Appsas;

class Response
{
    public mixed $content;
    public bool $redirect = false;
    public ?string $redirectUrl;

    public function __construct(mixed $content)
    {
        $this->content = $content;
    }

    public function redirect(string $url, mixed $content = null): self
    {
        $this->content = $content;
        $this->redirect = true;
        $this->redirectUrl = $url;
        return $this;
    }
}