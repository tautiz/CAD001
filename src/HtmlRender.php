<?php

namespace Appsas;

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
        ];

        foreach ($duomMas as $key => $value) {
            $failoTurinys = str_replace('{{' . $key . '}}', $value, $failoTurinys);
        }

        return $failoTurinys;
    }
}