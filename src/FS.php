<?php

namespace Appsas;

class FS
{
    private string $failoTurinys;

    public function __construct(private string $fileName)
    {
        $this->failoTurinys = file_get_contents($this->fileName);
    }

    public function getFailoTurinys(): string
    {
        return $this->failoTurinys;
    }
}