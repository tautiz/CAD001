<?php

namespace Appsas\Managers;

use Appsas\Repositories\RepositoryInterface;
use Appsas\Request;

class BaseManager
{
    protected RepositoryInterface $repository;

    public function getAll(): array
    {
        return $this->repository->all();
    }

    public function getOne(Request $request): array
    {
        $id = $request->get('id');
        return $this->repository->findById($id);
    }

    public function store(Request $request): void
    {
        $data = $request->all();
        $this->repository->create($data);
    }

    public function update(Request $request): void
    {
        $data = $request->all();
        $this->repository->update($data);
    }

    public function delete(Request $request): void
    {
        $id = $request->get('id');
        $this->repository->delete($id);
    }
}