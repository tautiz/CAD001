<?php

require_once 'Grupe.php';
require_once 'Person.php';
require_once 'GaliMokytis.php';
require_once 'Lytis.php';

class Student extends Person implements GaliMokytis
{
    use Lytis;

    /**
     * @param int $id
     * @param string $vardas
     * @param string $pavarde
     * @param int $asmensKodas
     * @param Grupe|null $grupe
     */
    public function __construct(
        int $id,
        string $vardas,
        string $pavarde,
        int $asmensKodas,
        private Grupe|null $grupe = null
    ) {
        parent::__construct($id, $vardas, $pavarde, $asmensKodas);
    }

    public function getGrupe(): Grupe|null
    {
        return $this->grupe;
    }

    public function priskirtiGrupe(Grupe $grupe): void
    {
        $this->grupe = $grupe;
        $grupe->pridetiStudenta();
    }

    public function mokytis(Dalykas $dalykas): void
    {
        echo "Aš {$this->getVardas()} {$this->getPavarde()} mokausi {$dalykas->getPavadinimas()}";
    }
}
