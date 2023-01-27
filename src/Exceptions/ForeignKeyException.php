<?php

namespace Appsas\Exceptions;

use Exception;

class ForeignKeyException extends Exception
{
    public function __construct($message = "Foreign key exception", $code = 1451, $exception = null)
    {
        parent::__construct($message, $code, $exception);
    }
}