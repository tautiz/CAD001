<?php

namespace SqrtApp;

use SqrtApp\Calculate\Calculator;
use SqrtApp\IO\cli\Input;
use SqrtApp\IO\Output;

class Main
{
    public static function run(): void
    {
        $input = new Input();
        $number = $input->getNumber();
        $precision = $input->getPrecision();

        $calculator = new Calculator();
        $result = $calculator->calculate($number);

        $output = new Output();
        $output->display($result, $precision);
    }
}