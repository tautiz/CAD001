<?php

namespace Appsas\Exceptions;

use Exception;

class UnauthenticatedException extends Exception
{
    public function __construct($message = "Neteisingi prisijungimo duomenys", $code = 401)
    {
        parent::__construct($message, $code);
    }
}