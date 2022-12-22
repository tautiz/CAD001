<?php

include '../src/Car.php';

$bmw = new Car();
$bmw->spalva = 'Raudonas';
$bmw->greitis = '100 km/h';
$bmw->vaziuoti(1.5);
echo '<br>Rida: ' . $bmw->gautiRida();

echo '<hr>';
$audi = new Car();
$audi->spalva = 'Juoda';
$audi->greitis = '120 km/h';
$audi->vaziuoti(2);
echo '<br>Rida: ' . $audi->gautiRida();

