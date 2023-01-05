<?php

use Appsas\Authenticator;
use Appsas\Exceptions\UnauthenticatedException;
use Appsas\FS;
use Appsas\Output;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Appsas\HtmlRender;

require __DIR__ . '/../vendor/autoload.php';

$log = new Logger('Portfolios');
$log->pushHandler(new StreamHandler('../logs/klaidos.log', Logger::WARNING));

$output = new Output();

try {
    session_start();

    $userName = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    // Vieta kur atloginam vartotoja
    if ($_GET['logout'] ?? false) {
        $_SESSION['logged'] = false;
    }

    // Jei vartotojas prisijunges, tai setinam SESIJA i prisijunges
    // ir Pasisveikinam su lankytoju
    $authenticator = new Authenticator();
    if ($authenticator->authenticate($userName, $password)) {
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $userName ?? $_SESSION['username'];
        $render = new HtmlRender($output);
        $render->render();
    }

    // Jei vartotojas neprisijunges, tai rodom prisijungimo forma.
    // Ir jei vartotojas ivede blogus prisijungimus, informuojam ji
    else {
        // Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
        $failoSistema = new FS('../src/html/pradzia.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        $output->store($failoTurinys);
    }
} catch (UnauthenticatedException $e) {
    $output->store('Neteisingi prisijungimo duomenys');
    $log->warning($e->getMessage());
} catch (Exception $e) {
    $output->store('Oi nutiko klaida! Bandyk vėliau dar karta.');
    $log->error($e->getMessage());
}

// Spausdinam viska kas buvo 'Storinta' Output klaseje
$output->print();