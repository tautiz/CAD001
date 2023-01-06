<?php

namespace Appsas\Exceptions;

use Exception;

class PageNotFoundException extends Exception
{
    public function __construct(string $message = 'Sorry page not found', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
