<?php

$temp = [78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73];

function konvertuotiFarenheita($array)
{
    $farenheita = [];
    foreach ($array as $temp) {
        $farenheita[] = round(($temp - 32) * 5 / 9, 0);
    }
    return $farenheita;
}

function masyvoVidurkis($array) {
    $suma = null;
    foreach ($array as $element) {
        $suma += $element;
    }

    return $suma / count($array);
}

function spausdintiPirmusElementus($array, $kiek) {
    for ($i = 0; $i < $kiek; $i++) {
        echo " " . $array[$i];
    }

    echo "<br>";
}

function spausdintiGrafiskai($temp, $kiek)
{
    for ($i = 0; $i < $kiek; $i++) {
        echo "<div style='
                    height: $temp[$i]px;
                    background-color: gray; 
                    display: inline-block;
                    padding: 3px;
                    border: 1px solid red;'>
                 $temp[$i]
              </div>";
    }

    echo "<br>";
}

echo "Grafikas: ";
spausdintiGrafiskai($temp, count($temp));

$temp = konvertuotiFarenheita($temp);
echo "Grafikas (C): ";
spausdintiGrafiskai($temp, count($temp));

// 1-ma uzduotis
$vidurkis = masyvoVidurkis($temp);
// Arba
//$vidurkis = array_sum($temp) / count($temp);
echo "Vidutinė temperatūra: $vidurkis";

rsort($temp);
echo "<br>Penkios auksciausios: ";
spausdintiPirmusElementus($temp, 5);

sort($temp);
echo "Penkios zemiausios: ";
spausdintiPirmusElementus($temp, 5);
