<?php

include_once '../src/Student.php';

$studentai = [
    ['vardas' => 'Jonas', 'pavarde' => 'Jonaitis', 'asmensKodas' => 38304056789],
    ['vardas' => 'Petras', 'pavarde' => 'Petraitis', 'asmensKodas' => 38706054321],
    ['vardas' => 'Antanas', 'pavarde' => 'Antanaitis', 'asmensKodas' => 3911111111],
    ['vardas' => 'Tomas', 'pavarde' => 'Tomaitis', 'asmensKodas' => 50002222222],
    ['vardas' => 'Juozas', 'pavarde' => 'Juozaitis', 'asmensKodas' => 51503033333],
    ['vardas' => 'Kazys', 'pavarde' => 'Kazlauskas', 'asmensKodas' => 37504044444],
    ['vardas' => 'Mantas', 'pavarde' => 'Mantaitis', 'asmensKodas' => 395555555],
    ['vardas' => 'Rita', 'pavarde' => 'Ritaitė', 'asmensKodas' => 60206066606],
    ['vardas' => 'Viktorija', 'pavarde' => 'Viktorytė', 'asmensKodas' => 60505057705],
    ['vardas' => 'Ona', 'pavarde' => 'Onienė', 'asmensKodas' => 48812128888],
    ['vardas' => 'Vardenis', 'pavarde' => 'Pavardenis', 'asmensKodas' => 999999999],
];

foreach ($studentai as $key => $studentas) {
    $studentaiObjektai[] = new Student($key, $studentas['vardas'], $studentas['pavarde'], $studentas['asmensKodas']);
}

$grupes = [
    ['pavadinimas' => 'CS1V', 'adresas' => 'Kaunas'],
    ['pavadinimas' => 'CS2D', 'adresas' => 'Vilnius'],
    ['pavadinimas' => 'CS3V', 'adresas' => 'Klaipeda'],
    ['pavadinimas' => 'CS4V', 'adresas' => 'Siauliai'],
    ['pavadinimas' => 'CS5D', 'adresas' => 'Panevezys'],
];

foreach ($grupes as $key => $grupe) {
    $grupesObjektai[] = new Grupe($key, $grupe['pavadinimas'], $grupe['adresas']);
}

/** @var Student $studentas */
foreach ($studentaiObjektai as $studentas) {
    $grupe = $grupesObjektai[rand(0, 4)];
    $studentas->priskirtiGrupe($grupe);
}

spausdintiPagalLyti($studentaiObjektai);
spausdintiVyriausia($studentaiObjektai);
spausdintiJauniausia($studentaiObjektai);
//generuotiForma();
//$filtrStud = filtruotiPagalGrupe($studentaiObjektai, $_POST['grupes_tipas']);
spausdintiStudentus($studentaiObjektai);

function spausdintiJauniausia(array $studentaiObjektai): void
{
    $vyriausias = $studentaiObjektai[0];
    foreach ($studentaiObjektai as $studentas) {
        if ($studentas->getGimimoData() > $vyriausias->getGimimoData()) {
            $vyriausias = $studentas;
        }
    }
    echo 'Jauniausias studentas: <ul>';
    spausdintiStudentus([$vyriausias], 'li');
    echo '</ul>';
}
function spausdintiVyriausia(array $studentaiObjektai): void
{
    $vyriausias = $studentaiObjektai[0];
    foreach ($studentaiObjektai as $studentas) {
        if ($studentas->getGimimoData() < $vyriausias->getGimimoData()) {
            $vyriausias = $studentas;
        }
    }
    echo 'Vyriausias studentas: <ul>';
    spausdintiStudentus([$vyriausias], 'li');
    echo '</ul>';
}
function spausdintiStudentus(array $studentaiObjektai, string $elementas = 'div'): void
{
    foreach ($studentaiObjektai as $studentas) {
        echo "<$elementas>"
            . $studentas->getVardas()
            . ' ' . $studentas->getPavarde()
            . ' ' . $studentas->getAsmensKodas()
            . ' ' . $studentas->getGrupe()?->getPavadinimas()
            . ' ' . $studentas->getGrupe()?->getAdresas()
            . "</$elementas>";
    }
}
function spausdintiPagalLyti(array $studentaiObjektai): void
{
    $vyras = [];
    $moteris = [];
    foreach ($studentaiObjektai as $studentas) {
        if ($studentas->getLytis() === 'Vyras') {
            $vyras[] = $studentas;
        }elseif ($studentas->getLytis() === 'Moteris') {
            $moteris[] = $studentas;
        }
    }
    echo 'Vyrų studentų sąrašas: <ul>';
    spausdintiStudentus($vyras, 'li');
    echo '</ul><br>';
    echo 'Moterų studentų sąrašas: <ul>';
    spausdintiStudentus($moteris, 'li');
    echo '</ul>';
}
