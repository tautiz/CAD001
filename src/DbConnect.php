<?php

namespace KCS;

use PDO;
use PDOException;

class DbConnect
{
    public static function tikrintiPrisijungima($host, $user, $password, $db): void
    {
        try {
            $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
            // Nustatome PDO Klaidų rėžimą į 'Exception'
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo '<br>Duomenų bazė veikia';
        } catch(PDOException $e) {
            echo '<br>Duomenų bazė neveikia: ' . $e->getMessage();
        }
    }
}
