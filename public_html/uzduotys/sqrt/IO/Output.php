<?php

namespace SqrtApp\IO;

class Output
{
    public function display($number, $precision): void
    {
        echo number_format($number, $precision) . "\n";
    }
}