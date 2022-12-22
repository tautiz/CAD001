<?php

class Car
{
    public string $spalva;
    public string $greitis;
    private float $rida;

    public function __construct()
    {
        $this->rida = 0;
    }

    public function vaziuoti(float $valandos): void
    {
        echo $this->gautiSpalva() ." automobilis važiuoja " . $this->greitis . " greičiu";
        $this->rida += (int) $this->greitis * $valandos;
    }

    public function gautiSpalva(): string
    {
        return $this->spalva;
    }

    public function gautiRida(): float
    {
        return $this->rida;
    }
}
