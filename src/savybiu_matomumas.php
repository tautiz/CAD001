<?php

class Automobilis
{
    public string $marke;
    protected string $modelis;
    private float $galia;

    public function __construct(string $marke, string $modelis, float $galia)
    {
        $this->marke = $marke;
        $this->modelis = $modelis;
        $this->galia = $galia;
    }

    public function informacija(): string
    {
        return "Automobilio markė: $this->marke, modelis: $this->modelis, galia: $this->galia kW";
    }

    protected function keitimas($naujaGalia): void
    {
        $this->galia = $naujaGalia;
    }

    private function patikrinimas(): string
    {
        return 'Automobilis patikrintas';
    }

    public function gautiGalia(): float
    {
        return $this->galia;
    }

    public function keistiGalia($naujaGalia): void
    {
        $naujaGalia += 10;
        $this->keitimas($naujaGalia);
    }
}

$automobilis = new Automobilis("BMW", "M3", 450);
echo $automobilis->informacija();  // "Automobilio markė: BMW, modelis: M3, galia: 450 kW"

// Negalima pasiekti "private" savybės iš už klasės ribų
//echo $automobilis->galia;  // Klaida
echo $automobilis->gautiGalia();  // 450

// Negalima naudoti "private" metodo iš už klasės ribų
//echo $automobilis->patikrinimas();  // Klaida

// Galima naudoti "public" metodą iš už klasės ribų
echo $automobilis->informacija();  // "Automobilio markė: BMW, modelis: M3, galia: 450 kW"

// Negalima naudoti "protected" metodo iš už klasės ribų
//$automobilis->keitimas(500);  // Klaida
$automobilis->keistiGalia(500);  // nustatysim i  510
