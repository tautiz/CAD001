<?php

namespace Appsas\Controllers;

use Appsas\Database;
use Appsas\FS;
use Appsas\Validator;
use Exception;
use PDO;
use Appsas\Configs;
use PDOException;

class PortfolioController
{
    public function index()
    {
//      Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
        $failoSistema = new FS('../src/html/portfolio.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        return $failoTurinys;
    }

    public function store()
    {
        $vardas = $_POST['vardas'] ?? '';
        $pavarde = $_POST['pavarde'] ?? '';
        $kodas = (int)$_POST['kodas'] ?? '';

        Validator::required($vardas);
        Validator::required($pavarde);
        Validator::required($kodas);
        Validator::numeric($kodas);
        Validator::asmensKodas($kodas);

        $conf = new Configs();
        $conn = new Database($conf);

        $conn->query(
            "INSERT INTO `persons` (`first_name`, `last_name`, `code`)
                    VALUES (:vardas, :pavarde, :kodas)",
            [
                'vardas' => $vardas,
                'pavarde' => $pavarde,
                'kodas' => $kodas,
            ]
        );

        echo "New record created successfully";
    }
}