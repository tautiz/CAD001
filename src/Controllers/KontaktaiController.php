<?php

namespace Appsas\Controllers;

use Appsas\FS;
use Appsas\Response;
use Monolog\Logger;

class KontaktaiController extends BaseController
{
    private Logger $log;

    public function __construct(Logger $log)
    {
        $this->log = $log;
        parent::__construct();
    }

    public function index(): Response
    {
        return $this->render('kontaktai');
    }
}