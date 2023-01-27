<?php

namespace Appsas\Controllers;

use Appsas\Request;
use Appsas\Response;

interface ControllerInterface
{
    public function list(Request $request): Response;

    public function show(Request $request): Response;

    public function store(Request $request): Response;

    public function update(Request $request): Response;

    public function delete(Request $request): Response;

}