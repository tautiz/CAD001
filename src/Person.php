<?php

abstract class Person
{
    public function __construct(
        private int $id,
        private string $vardas,
        private string $pavarde,
        private int $asmensKodas
    ) {
    }

    abstract function getLytis(): string|null;

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
    public function getVardas(): string
    {
        return $this->vardas;
    }

    /**
     * @return string
     */
    public function getPavarde(): string
    {
        return $this->pavarde;
    }

    /**
     * @return int
     */
    public function getAsmensKodas(): int
    {
        return $this->asmensKodas;
    }

    public function getGimimoData(): DateTime
    {
        $milenium = $this->gautiTukstantmeti();
        $gimimoMetai = $milenium + substr($this->asmensKodas, 1, 2);
        $gimimoMenuo = substr($this->asmensKodas, 3, 2);
        $gimimoDiena = substr($this->asmensKodas, 5, 2);
        $gimimoData = new DateTime();
        $gimimoData->setDate($gimimoMetai, $gimimoMenuo, $gimimoDiena);
        return $gimimoData;
    }

    /**
     * @return int
     */
    public function gautiTukstantmeti(): int
    {
        if (in_array(substr($this->asmensKodas, 0, 1), [5, 6])) {
            $milenium = 2000;
        } else {
            $milenium = 1900;
        }

        return $milenium;
    }
}