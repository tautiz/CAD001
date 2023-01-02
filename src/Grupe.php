<?php

include_once '../src/Student.php';

class Grupe
{
    /**
     * @param int $id
     * @param string $pavadinimas
     * @param string $adresas
     * @param int $studentuKiekis
     */
    public function __construct(
        private int $id,
        private string $pavadinimas,
        private string $adresas,
        private int $studentuKiekis = 0
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPavadinimas(): string
    {
        return $this->pavadinimas;
    }

    /**
     * @return string
     */
    public function getAdresas(): string
    {
        return $this->adresas;
    }

    /**
     * @return int
     */
    public function getStudentuKiekis(): int
    {
        return $this->studentuKiekis;
    }

    public function pridetiStudenta(): void
    {
        $this->studentuKiekis++;
    }
}
