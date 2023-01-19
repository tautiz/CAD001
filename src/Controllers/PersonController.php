<?php

namespace Appsas\Controllers;

use Appsas\Database;
use Appsas\FS;
use Appsas\Validator;
use Appsas\Configs;

class PersonController
{
    public function index()
    {
        $config = new Configs();
        $db = new Database($config);

        $kiekis = $_GET['amount'] ?? 10;

        $asmenys = $db->query('SELECT * FROM persons ORDER BY id DESC LIMIT ' . $kiekis);

        $rez = '<table>
            <tr>
                <th>ID</th>
                <th>Vardas</th>
                <th>Pavarde</th>
                <th>Emailas</th>
                <th>Asmens kodas</th>
                <th>TEl</th>
                <th>Addr.ID</th>
                <th>Veiksmai</th>
            </tr>';
        foreach ($asmenys as $asmuo) {
            $rez .= '<tr>';
            $rez .= '<td>' . $asmuo['id'] . '</td>';
            $rez .= '<td>' . $asmuo['first_name'] . '</td>';
            $rez .= '<td>' . $asmuo['last_name'] . '</td>';
            $rez .= '<td>' . $asmuo['email'] . '</td>';
            $rez .= '<td>' . $asmuo['code'] . '</td>';
            $rez .= '<td>' . $asmuo['phone'] . '</td>';
            $rez .= '<td>' . $asmuo['address_id'] . '</td>';
            $rez .= "<td><a href='/person/delete?id={$asmuo['id']}'>Šalinti</a></td>";
            $rez .= '</tr>';
        }
        $rez .= '</table>';

        $failoSistema = new FS('../src/html/persons.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        $failoTurinys = str_replace("{{body}}", $rez, $failoTurinys);

        return $failoTurinys;

    }

    public function new()
    {
//      Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
        $failoSistema = new FS('../src/html/new_person.html');
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
}