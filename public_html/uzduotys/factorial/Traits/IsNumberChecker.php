<?php

namespace Factorial\Traits;

trait IsNumberChecker
{
    public function isNumber($number): bool
    {
        return is_numeric($number);
    }
}