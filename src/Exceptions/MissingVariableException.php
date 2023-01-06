<?php

namespace Appsas\Exceptions;

use Exception;

class MissingVariableException extends Exception
{
    public function __construct($message = "Nerastas Kintamasis", $code = 404)
    {
        parent::__construct($message, $code);
    }
}