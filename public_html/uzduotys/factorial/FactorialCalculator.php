<?php

namespace Factorial;

use Exception;
use Factorial\Traits\IsNumberChecker;
use Factorial\Traits\PositiveNumberChecker;
use Factorial\Calculator;

abstract class FactorialCalculator implements Calculator
{
    use PositiveNumberChecker;
    use IsNumberChecker;

    // Method checks if the number is positive

    /**
     * @throws Exception
     */
    public function validate($number)
    {
        if (!$this->check($number)) {
            throw new Exception("Number must be positive");
        }

        if (!$this->isNumber($number)) {
            throw new Exception("Factorial Input must be a number");
        }
    }

    // Method must be implemented by the subclass
    abstract public function calculate($number);
}