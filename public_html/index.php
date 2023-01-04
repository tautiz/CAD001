<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require __DIR__ . '/../vendor/autoload.php';

$log = new Logger('Portfolios');
$log->pushHandler(new StreamHandler('../logs/klaidos.log', Logger::WARNING));

try {
    $failoAdresas = '../src/html/pradzia.html';

    $failoTurinys = file_get_contents($failoAdresas);

    echo $failoTurinys;

    $userName = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

   if ($userName === 'admin' && $password === 'slapta') {
        echo 'Sveiki prisijunge';
    } elseif ($userName !== null && $password !== null) {
        echo 'Neteisingi prisijungimo duomenys';
    }

} catch (Exception $e) {
    echo 'Oi nutiko klaida! Bandyk vėliau dar karta.';
    $log->error($e->getMessage());
}