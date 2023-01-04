<?php

use Appsas\FS;
use Appsas\Output;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require __DIR__ . '/../vendor/autoload.php';

$log = new Logger('Portfolios');
$log->pushHandler(new StreamHandler('../logs/klaidos.log', Logger::WARNING));

$output = new Output();

try {
    session_start();

    $userName = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    // Vieta kur atliginam vartotoja
    if($_GET['logout'] ?? false) {
        $_SESSION['logged'] = false;
    }

    // Jei vartotojas prisijunges, tai setinam SESIJA i prisijunges
    // ir Pasisveikinam su lankytoju
    if (
        isset($_SESSION['logged']) && $_SESSION['logged'] === true
        ||
        ($userName === 'admin' && $password === 'slapta')
    ) {
        $_SESSION['logged'] = true;

// UZDUOTIS: Kazka padaryti kad cia paimtu ir surenderintu Dashboard.html faila

//        $output->store('Sveiki prisijungę<br><a href="index.php?logout=true">Atsijungti</a><br>');
    }
    // Jei vartotojas neprisijunges, tai rodom prisijungimo forma.
    // Ir jei vartotojas ivede blogus prisijungimus, informuojam ji
    else {
        // Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
        $failoSistema = new FS('../src/html/pradzia.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        $output->store($failoTurinys);

        // Tikrinam ar vartotojas ivede prisijungimo duomenis
        if ($userName !== null && $password !== null) {
            $output->store('Neteisingi prisijungimo duomenys');
        }
    }
} catch (Exception $e) {
    $output->store('Oi nutiko klaida! Bandyk vėliau dar karta.');
    $log->error($e->getMessage());
}

// Spausdinam viska kas buvo 'Storinta' Output klaseje
$output->print();