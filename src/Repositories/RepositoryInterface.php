<?php

namespace Appsas\Repositories;

interface RepositoryInterface
{
    public function create(array $data): void;
    public function findById(int $id): array;
    public function update(array $data): void;
    public function delete(int $id): void;
}