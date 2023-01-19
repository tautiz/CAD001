<?php

namespace Appsas\Controllers;

use Appsas\FS;
use Exception;
use PDO;
use Appsas\Configs;

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

        $kodas = !empty($_POST['kodas']) ? (int)$_POST['kodas'] != 0 ? (int)$_POST['kodas'] : '' : '';
//
//
//        if (!empty($_POST['kodas'])) {
//            $kodas = (int)$_POST['kodas'];
//            if ($kodas == 0) {
//                $kodas = '';
//            }
//        }


d($vardas, $pavarde, $kodas);
        $conf = new Configs();
        $servername = $conf->configs['db']['hostmane'];
        $dbname = $conf->configs['db']['dbname'];
        $username = $conf->configs['db']['username'];
        $password = $conf->configs['db']['password'];

        if (!$vardas || !$pavarde || !$kodas) {
            throw new Exception('Neuzpildyti visi laukai');
        }

        if (!is_numeric($kodas)) {
            throw new Exception('Kodas turi buti skaicius');
        }

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO `persons` (`first_name`, `last_name`, `code`) VALUES ('$vardas', '$pavarde', $kodas)";
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "New record created successfully";
    }
}