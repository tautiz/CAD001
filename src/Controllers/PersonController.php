<?php

namespace Appsas\Controllers;

use Appsas\Database;
use Appsas\FS;
use Appsas\Response;
use Appsas\Validator;
use Appsas\Configs;

class PersonController extends BaseController
{
    public const TITLE = 'Asmenys';

    public function list()
    {
        $config = new Configs();
        $db = new Database($config);

        $kiekis = $_GET['amount'] ?? 10;
        $orderBy = $_GET['orderby'] ?? 'id';

        $asmenys = $db->query('SELECT p.*, concat(c.title, \' - \', a.city, \' - \', a.street, \' - \', a.postcode) address
FROM persons p
    JOIN addresses a on p.address_id = a.id 
    JOIN countries c on a.country_iso = c.iso 
ORDER BY ' . $orderBy . ' DESC LIMIT ' . $kiekis);

        $rez = $this->generatePersonsTable($asmenys);

        $failoSistema = new FS('../src/html/person/list.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        $failoTurinys = str_replace("{{body}}", $rez, $failoTurinys);

        return $failoTurinys;
    }

    public function new()
    {
//      Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
        $failoSistema = new FS('../src/html/person/new.html');
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

        return "New record created successfully";
    }

    public function delete()
    {
        $kuris = (int)$_GET['id'] ?? null;

        Validator::required($kuris);
        Validator::numeric($kuris);
        Validator::min($kuris, 1);

        $conf = new Configs();
        $db = new Database($conf);

        $db->query("DELETE FROM `persons` WHERE `id` = :id", ['id' => $kuris]);

        return "Record deleted successfully";
    }

    public function edit()
    {
        $failoSistema = new FS('../src/html/person/edit.html');
        $failoTurinys = $failoSistema->getFailoTurinys();

        $conf = new Configs();
        $db = new Database($conf);

        $person = $db->query("SELECT * FROM `persons` WHERE `id` = :id", ['id' => $_GET['id']])[0];

        foreach ($person as $key => $item) {
            $failoTurinys = str_replace("{{" . $key . "}}", $item, $failoTurinys);
        }

        return $failoTurinys;
    }

    public function update(): Response
    {
        $id = $_POST['id'] ?? '';
        $vardas = $_POST['vardas'] ?? '';
        $pavarde = $_POST['pavarde'] ?? '';
        $id = (int)$_POST['id'] ?? '';
        $email = $_POST['email'] ?? '';
        $tel = $_POST['tel'] ?? '';
        $addrId = (int)$_POST['addr_id'] ?? '';
        $kodas = $_POST['kodas'] ?? '';

        Validator::required($vardas);
        Validator::required($pavarde);
        Validator::required($kodas);
        Validator::numeric($kodas);
        Validator::asmensKodas($kodas);

        $conf = new Configs();
        $db = new Database($conf);

        $db->query(
            "UPDATE `persons` SET `first_name` = :vardas, `last_name` = :pavarde, `code` = :kodas, `email` = :email,
                     `phone` = :tel, `address_id` = :addr_id WHERE `id` = :id",
            [
                'vardas' => $vardas,
                'pavarde' => $pavarde,
                'kodas' => $kodas,
                'email' => $email,
                'tel' => $tel,
                'addr_id' => $addrId,
                'id' => $id,
            ]
        );

        $response = new Response("Record updated successfully");
        $response->redirect('/persons');
        return $response;
    }

    public function show()
    {
        $failoSistema = new FS('../src/html/person/show.html');
        $failoTurinys = $failoSistema->getFailoTurinys();

        $conf = new Configs();
        $db = new Database($conf);

        $person = $db->query("SELECT * FROM `persons` WHERE `id` = :id", ['id' => $_GET['id']])[0];

        foreach ($person as $key => $item) {
            $failoTurinys = str_replace("{{" . $key . "}}", $item, $failoTurinys);
        }

        return $failoTurinys;
    }

    /**
     * @param mixed $asmuo
     * @return string
     */
    protected function generatePersonRow(array $asmuo): string
    {
        $failoSistema = new FS('../src/html/person/person_row.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        foreach ($asmuo as $key => $item) {
            $failoTurinys = str_replace("{{" . $key . "}}", $item, $failoTurinys);
        }

        return $failoTurinys;
    }

    /**
     * @param array $asmenys
     * @return string
     */
    protected function generatePersonsTable(array $asmenys): string
    {
        $rez = '<table class="highlight striped">
            <tr>
                <th>ID</th>
                <th>Vardas</th>
                <th>Pavarde</th>
                <th>Emailas</th>
                <th>Asmens kodas</th>
                <th><a href="/persons?orderby=phone">TEl</a></th>
                <th>Addr.ID</th>
                <th>Veiksmai</th>
            </tr>';
        foreach ($asmenys as $asmuo) {
            $rez .= $this->generatePersonRow($asmuo);
        }
        $rez .= '</table>';
        return $rez;
    }
}