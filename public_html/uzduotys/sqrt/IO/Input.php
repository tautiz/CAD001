<?php

namespace SqrtApp\IO;

class Input
{
    public function getNumber(): int
    {
        echo "Enter a number: ";
        $handle = fopen("php://stdin","r");
        $number = (int)fgets($handle);
        return $number;
    }

    public function getPrecision(): int
    {
        echo "Enter precision (2 or 4): ";
        $handle = fopen("php://stdin","r");
        $precision = (int)fgets($handle);
        return $precision;
    }
}