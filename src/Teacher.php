<?php

require_once 'GaliMokyti.php';
require_once 'Lytis.php';

class Teacher extends Person implements GaliMokyti
{
    use Lytis;

    private array $grupes = [];

    public function addGrupe(Grupe $grupe): void
    {
        $this->grupes[] = $grupe;
    }

    public function getGrupes(): array
    {
        return $this->grupes;
    }

    public function mokyti(Student $student): void
    {
        echo "Aš {$this->getVardas()} {$this->getPavarde()} mokau {$student->getVardas()} {$student->getPavarde()}";
    }
}