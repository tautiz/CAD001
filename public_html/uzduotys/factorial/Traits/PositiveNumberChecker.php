<?php

namespace Factorial\Traits;

trait PositiveNumberChecker
{
    public function check($number): bool
    {
        return $number > 0;
    }
}