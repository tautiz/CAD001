<?php

namespace Factorial;

use Exception;
use Factorial\FactorialCalculator;

class ConcreteFactorialCalculator extends FactorialCalculator
{
    /**
     * @throws Exception
     */
    public function calculate($number): float
    {
        $this->validate($number);
        $result = 1;
        for ($i = 1; $i <= $number; $i++) {
            $result *= $i;
        }

        return $result;
    }
}

