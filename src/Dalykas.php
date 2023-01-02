<?php

class Dalykas
{
    private string $pavadinimas;

    public function __construct(string $pavadinimas)
    {
        $this->pavadinimas = $pavadinimas;
    }

    public function getPavadinimas(): string
    {
        return $this->pavadinimas;
    }
}