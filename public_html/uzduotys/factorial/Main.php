<?php

namespace Factorial;

use Exception;
use Factorial\ConcreteFactorialCalculator;

class Main
{
    /**
     * @throws Exception
     */
    public static function run(): void
    {
        $calculator = new ConcreteFactorialCalculator();
        $result = $calculator->calculate(5);
        echo $result; // Outputs 24
    }
}