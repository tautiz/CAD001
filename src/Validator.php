<?php

namespace Appsas;

use Appsas\Exceptions\ValidatorException;

class Validator
{
    public static function required($value): void
    {
        if (empty($value)) {
            throw new ValidatorException('Neuzpildyti visi laukai');
        }
    }

    public static function numeric($value): void
    {
        if (!is_numeric($value)) {
            throw new ValidatorException('Laukas turi buti skaicius');
        }
    }

    public static function asmensKodas(int $kodas)
    {
        if(strlen($kodas) != 11
            || $kodas == 0
            || !in_array(substr($kodas, 0, 1), [3,4,5,6])
        ) {
            throw new ValidatorException('Netinkamas asmens kodas');
        }
    }

    public static function min(int $kuris, int $min)
    {
        if($kuris < $min) {
            throw new ValidatorException('Per mazas skaitmuo. Reikalaujamas dydis min. ' . $min);
        }
    }
}