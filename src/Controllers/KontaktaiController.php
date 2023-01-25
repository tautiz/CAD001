<?php

namespace Appsas\Controllers;

use Appsas\Response;

class KontaktaiController extends BaseController
{
    public function index(): Response
    {
        return $this->render('kontaktai');
    }
}