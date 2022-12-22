<?php
 // ---------------------------- Deklaruoju kintamuosius ir funkcijas ----------------------------
function gautiJsonString(): string
{
    return file_get_contents('duomenys.json');
}

/**
 * @return array
 */
function gautiStudentus(): array
{
    $studentai = json_decode(gautiJsonString(), true);

    return $studentai;
}

/**
 * @param array $studentai
 * @return void
 */
function printStudents(array $studentai): void
{
    foreach ($studentai as $raktas => $studentas) {
        echo 'Eil.nr.: ' . $raktas . ' ] ' . $studentas['vardas'] . ' ' . $studentas['pavarde'] . ' ' . $studentas['amzius'] . '<br>';
    }
}

function gautiStudentoAmziu(array $studentas): int
{
    return $studentas['amzius'];
}

function gautiStudentuAmziausSuma(array $studentai): int
{
    $suma = 0;
    foreach ($studentai as $studentas) {
        $suma += gautiStudentoAmziu($studentas);
    }

    return $suma;
}

function skaiciuotiStudentuAmziausVidurki(array $studentai): float
{
    $suma = gautiStudentuAmziausSuma($studentai);
    $kiekis = count($studentai);

    return $suma / $kiekis;
}


// ---------------------------- Studento [CRUD] ----------------------------
function sukurtiStudenta(array $studentas): void
{
    $studentai = gautiStudentus(); // Gauti senus studentus
    $studentai[] = $studentas;     // pridedam naują studentą prie senų
    $jsonString = json_encode($studentai); // konvertuojam naują studentų masyvą į json string
    file_put_contents('duomenys.json', $jsonString); // įrašom naują json string į failą
}

function gautiStudenta(int $id): array
{
    $studentai = gautiStudentus(); // Gauti senus studentus
    $studentas = $studentai[$id];

    return $studentas;
}

function atnaujintiStudenta(int $id, array $studentas): void
{
    $studentai = gautiStudentus(); // Gauti senus studentus
    $studentai[$id] = $studentas;  // pakeičiam seną studentą nauju
    $jsonString = json_encode($studentai); // konvertuojam naują studentų masyvą į json string
    file_put_contents('duomenys.json', $jsonString); // įrašom naują json string į failą
}

function istrintiStudenta(int $id): void
{
    $studentai = gautiStudentus(); // Gauti senus studentus
    unset($studentai[$id]);        // ištrinam studentą
    $jsonString = json_encode($studentai); // konvertuojam naują studentų masyvą į json string
    file_put_contents('duomenys.json', $jsonString); // įrašom naują json string į failą
}

// ---------------------------- Baigiu deklaracijas ----------------------------

// ----------------------------Ppradedu isvedima ----------------------------
$studentai = gautiStudentus();
echo 'Pries sukurima senas vidurkis: ' . skaiciuotiStudentuAmziausVidurki($studentai);

sukurtiStudenta(['vardas' => 'Linas', 'pavarde' => 'Linutis', 'amzius' => 50]);

$studentai = gautiStudentus();
echo '<br>Su nauju studentu vidurkis: ' . skaiciuotiStudentuAmziausVidurki($studentai);

//$paskutinisStudentas = gautiStudenta(count($studentai) - 1);

atnaujintiStudenta(0, ['vardas' => 'Rokas', 'pavarde' => 'Rokutis', 'amzius' => 99]);

$studentai = gautiStudentus();
echo '<br>Naujas vidurkis po atnaujinimo: ' . skaiciuotiStudentuAmziausVidurki($studentai);

$paskutinioStudentoId = count($studentai) - 1;
istrintiStudenta($paskutinioStudentoId);

$studentai = gautiStudentus();
echo '<br>Naujas vidurkis po trynimo: ' . skaiciuotiStudentuAmziausVidurki($studentai);