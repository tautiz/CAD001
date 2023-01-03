<?php

include 'Main.php';

try {
    Factorial\Main::run();
} catch (Exception $e) {
    echo 'Oi nutiko gyvenimas... Štai tavo klaida: ' . $e->getMessage();
}
