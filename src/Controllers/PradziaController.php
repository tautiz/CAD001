<?php

namespace Appsas\Controllers;

use Appsas\Response;
use Appsas\Request;

class PradziaController extends BaseController
{
    public function index(Request $request): Response
    {
        return $this->render('pradzia', $request->all());
    }
}