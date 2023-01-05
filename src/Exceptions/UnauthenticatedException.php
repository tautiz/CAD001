<?php

namespace Appsas\Exceptions;

use Exception;

class UnauthenticatedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Neteisingi prisijungimo duomenys', 401);
    }
}