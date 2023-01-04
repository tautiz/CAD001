<?php

namespace Appsas;

class Output
{
    public function __construct(private array $output = [])
    {
    }

    public function store(mixed $duomenys): void
    {
        $this->output[] = $duomenys;
    }

    public function print(): void
    {
        foreach ($this->output as $eilute) {
            echo $eilute;
        }
    }
}