<?php

namespace Appsas\Controllers;

use Appsas\FS;
use Appsas\Response;
use Appsas\Request;

class PradziaController extends BaseController
{
    public function index(Request $request): Response
    {
        // Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
        $failoSistema = new FS('../src/html/pradzia.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        foreach ($request->all() as $key => $item) {
            $failoTurinys = str_replace("{\{$key}}", $item, $failoTurinys);
        }
        return $this->response($failoTurinys);
    }
}