<?php

namespace Appsas;

class Request
{
    public function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    public function get(string $string, mixed $default = null): mixed
    {
        return $this->all()[$string] ?? $default;
    }
}