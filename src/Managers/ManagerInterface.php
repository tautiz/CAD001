<?php

namespace Appsas\Managers;

use Appsas\Request;

interface ManagerInterface
{
    public function getAll(): array;

    public function getOne(Request $request): array;

    public function store(Request $request): void;

    public function update(Request $request): void;

    public function delete(Request $request): void;
}