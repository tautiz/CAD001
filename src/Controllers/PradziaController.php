<?php

namespace Appsas\Controllers;

use Appsas\FS;

class PradziaController
{
    public function index()
    {
        // Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
        $failoSistema = new FS('../src/html/pradzia.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        foreach ($_REQUEST as $key => $item) {
            $failoTurinys = str_replace("{{$key}}", $item, $failoTurinys);
        }
        return $failoTurinys;
    }
}