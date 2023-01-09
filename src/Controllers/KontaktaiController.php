<?php

namespace Appsas\Controllers;

use Appsas\FS;
use Monolog\Logger;

class KontaktaiController
{
    private Logger $log;

    public function __construct(Logger $log)
    {
        $this->log = $log;
    }

    public function index()
    {
        {
            // Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
            $failoSistema = new FS('../src/html/kontaktai.html');
            $failoTurinys = $failoSistema->getFailoTurinys();
            $this->log->info('Kontaktai atidaryti');

            return $failoTurinys;
        }
    }
}