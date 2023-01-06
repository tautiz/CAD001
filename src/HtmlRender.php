<?php

namespace Appsas;

use Appsas\Exceptions\MissingVariableException;
use Appsas\FS;

class HtmlRender extends AbstractRender
{
    protected function getContent(): string
    {
        $failoSistema = new FS('../src/html/Dashboard.html');
        $failoTurinys = $failoSistema->getFailoTurinys();

        $duomMas = [
            'username' => $_SESSION['username'],
            'userType' => 'Admin',
            'loggedInDate' => date('Y-m-d H:i:s'),
            'nera_sito_raktazodzio' => 'Turi ismesti klaida',
        ];

        foreach ($duomMas as $key => $value) {
            if (!str_contains($failoTurinys, '{{' . $key . '}}')) {
                throw new MissingVariableException('Nerastas raktazodis: ' . $key);
            }
            $failoTurinys = str_replace('{{' . $key . '}}', $value, $failoTurinys);
        }

        return $failoTurinys;
    }
}