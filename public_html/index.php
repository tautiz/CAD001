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

// ---------------------------- Baigiu deklaracijas ----------------------------

// ---------------------------- Pradedu vykdyma ----------------------------

$studentai = gautiStudentus();

// ---------------------------- Baigiu vykdyma ----------------------------

// ----------------------------Ppradedu isvedima ----------------------------
echo skaiciuotiStudentuAmziausVidurki($studentai);