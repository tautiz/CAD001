<?php

$ceu = [
    "Italy" => "Rome",
    "Luxembourg" => "Luxembourg",
    "Belgium" => "Brussels",
    "Denmark" => "Copenhagen",
    "Finland" => "Helsinki",
    "France" => "Paris",
    "Slovakia" => "Bratislava",
    "Slovenia" => "Ljubljana",
    "Germany" => "Berlin",
    "Greece" => "Athens",
    "Ireland" => "Dublin",
    "Netherlands" => "Amsterdam",
    "Portugal" => "Lisbon",
    "Spain" => "Madrid",
    "Sweden" => "Stockholm",
    "United Kingdom" => "London",
    "Cyprus" => "Nicosia",
    "Lithuania" => "Vilnius",
    "Czech Republic" => "Prague",
    "Estonia" => "Tallin",
    "Hungary" => "Budapest",
    "Latvia" => "Riga",
    "Malta" => "Valetta",
    "Austria" => "Vienna",
    "Poland" => "Warsaw",
];

// a.) Nerikiuotus duomenis ir atspausdinti

function spausdintiMasyvaSuForech($array)
{
    echo "<br>Foreach<hr>";
    foreach ($array as $valst => $sost) {
        echo "Valstybe $valst jos sostine $sost<br>";
    }
}

//spausdintiMasyvaSuForech($ceu);

function spausdintiMasyvaSuWile($array)
{
    echo "<br>While<hr>";
    $i = 0;
    while ($i < count($array)) {
        $valst1 = array_keys($array)[$i];
        $sost1 = array_values($array)[$i];
        echo "Valstybe $valst1 jos sostine $sost1<br>";
        $i++;
    }
}

//spausdintiMasyvaSuWile($ceu);
function spaustintiMasyvaSuDoWhile($array)
{
    echo "<br>Do While<hr>";
    $i = 0;
    do {
        $valst2 = array_keys($array)[$i];
        $sost2 = array_values($array)[$i];
        echo "Valstybe $valst2 jos sostine $sost2<br>";
        $i++;
    } while ($i < count($array));
}

//spaustintiMasyvaSuDoWhile($ceu);

function spausdintiMasyvaSuFor($ceu)
{
    echo "<br>For<hr>";
    for ($i = 0; $i < count($ceu); $i++) {
        $valst2 = array_keys($ceu)[$i];
        $sost2 = array_values($ceu)[$i];
        echo "Valstybe $valst2 jos sostine $sost2<br>";
    }
}

//spausdintiMasyvaSuFor($ceu);

//    b.) Surikiuoti šalis abėcėlės tvarka ir atspausdinti.
asort($ceu);
//spausdintiMasyvaSuForech($ceu);

//    c.) Spausdinti kas $x -tąjį masyvo elementą
function spausdintiKiekvienaX($array, $x)
{
    echo "<br>Kiekviena $x -tasis elementas<hr>";
    for ($i = 0; $i < count($array); $i = $i + $x) {
        $valst2 = array_keys($array)[$i];
        $sost2 = array_values($array)[$i];
        echo "Valstybe $valst2 jos sostine $sost2<br>";
    }
}

//spausdintiKiekvienaX($ceu, 2);
//spausdintiKiekvienaX($ceu, 5);

//    d.) Visus variantus kurie turi raidę $char = “A”; (Case sensitive)
function spausdintiMasyvaPagalRaide($array, $char)
{
    echo "<br>Spausdinti pagal raide: $char<hr>";
    foreach ($array as $valst => $sost) {
        arTuriRaide($valst, $char, $valst, $sost);
        arTuriRaide($sost, $char, $valst, $sost);
    }
}

function arTuriRaide($kur, $ko, $valst, $sost)
{
    if (strpos($kur, $ko) !== false) {
        echo "Valstybe $valst jos sostine $sost<br>";
    }
}

//spausdintiMasyvaPagalRaide($ceu, "a");

// e.) Atskirti masyvą per pusę ir jo duomenis spausdinti atskirose sekcijose DIV elementuose,
// tačiau jos turi būti inline stiliaus (viena šalia kitos).
function spausdintiMasyvaPerPuse($array)
{
    echo "<br>Spausdinti per pusę<hr>";
    $i = 0;
    $puse = ceil(count($array) / 2);
    while ($i < count($array)) {
        $valst = array_keys($array)[$i];
        $sost = array_values($array)[$i];
        arDivPradzia($i, $puse);
        echo "Valstybe $valst jos sostine $sost<br>";
        arDivPabaiga($puse, $i, $array);
        $i++;
    }
}

function arDivPabaiga($puse, $i, $array)
{
    if ($i == $puse - 1 || $i == count($array) - 1) {
        echo "</div>";
    }
}

function arDivPradzia($i, $puse)
{
    if ($i == 0 || $i == $puse) {
        echo "<div style='display: inline-block; margin: 10px;'>";
    }
}

spausdintiMasyvaPerPuse($ceu);
