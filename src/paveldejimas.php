<?php

class Gyvunas {
    protected $tipas;
    protected $svoris;
    protected $ugis;

    public function __construct($tipas) {
        $this->tipas = $tipas;
    }

    public function informacija() {
        return "Gyvūno tipas: " . $this->tipas;
    }

    function getTipas() {
        return $this->tipas;
    }
}

class Zinduolis extends Gyvunas {
    protected $spalva;

    public function __construct($tipas, $spalva) {
        parent::__construct($tipas);
        $this->spalva = $spalva;
    }

    public function informacija() {
        $info = parent::informacija();
        $info .= ", spalva: " . $this->spalva;
        return $info;
    }
}

class Paukstis extends Gyvunas {
    protected $skraidymoGreitis;

    public function __construct($tipas, $skraidymoGreitis) {
        parent::__construct($tipas);
        $this->skraidymoGreitis = $skraidymoGreitis;
    }

    public function informacija() {
        $info = parent::informacija();
        $info .= ", skraidymo greitis: " . $this->skraidymoGreitis . " km/h";
        return $info;
    }
}

$zinduolis = new Zinduolis("žinduolis", "ruda");
echo $zinduolis->informacija();  // "Gyvūno tipas: žinduolis, spalva: ruda"
echo $zinduolis->getTipas(); // "žinduolis"

$paukstis = new Paukstis("Vėžlys", 100);
echo $paukstis->informacija();  // "Gyvūno tipas: Vėžlys, skraidymo greitis: 100 km/h"
echo $paukstis->getTipas(); // "Vėžlys"
