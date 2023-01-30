<?php

namespace Appsas\Managers;

use Appsas\Models\ModelInterface;
use Appsas\Repositories\RepositoryInterface;
use Appsas\Request;
use ReflectionClass;
use ReflectionException;

class BaseManager
{
    protected RepositoryInterface $repository;

    public function getRepository(): RepositoryInterface
    {
        return $this->repository;
    }

    public function getModelName(): string
    {
        $classNamespace = $this->repository->getModelClass();
        $classWithSlash = basename(strrchr($classNamespace, '\\'));
        return substr($classWithSlash, 1);
    }

    public function getAll(): array
    {
        return $this->repository->all();
    }

    public function getOne(Request $request): ModelInterface
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


    public function getTotal(): int
    {
        $table = $this->repository->getTableName();
        $sql = "SELECT COUNT(*) total FROM $table";
        $repository = $this->getRepository();
        $database = $repository->getDb();
        $queryRows = $database->query($sql, [], 'stdClass');
        $singleRowObject = $queryRows[0];

        return $singleRowObject->total;
    }

    /**
     * @throws ReflectionException
     */
    public function getListOfTableColumns(): array
    {
        $modelClass = $this->repository->getModelClass();
        $reflectionProperties = (new ReflectionClass($modelClass))->getProperties();
        $properties = [];
        /** ReflectionProperty $reflectionProperty */
        foreach ($reflectionProperties as $reflectionProperty) {
            if (class_exists($reflectionProperty->getType()->getName())
            ) {
                continue;
            }
            $properties[] = $reflectionProperty->getName();
        }

        return $properties;
    }

    public function getFiltered(Request $request): array
    {
        $page = $request->get('page', 1);
        $limit = $request->get('amount', 10);
        $orderBy = $request->get('orderby', 'id');
        $page = (int)max($page, 1);
        $offset = ($page - 1) * $limit;

        $where = [];
        $params = [];
        if ($request->get('first_name')) {
            $where[] = 'first_name LIKE :first_name';
            $params['first_name'] = '%' . $request->get('first_name') . '%';
        }
        if ($request->get('last_name')) {
            $where[] = 'last_name LIKE :last_name';
            $params['last_name'] = '%' . $request->get('last_name') . '%';
        }
        if ($request->get('code')) {
            $where[] = 'code LIKE :code';
            $params['code'] = '%' . $request->get('code') . '%';
        }
        if ($request->get('email')) {
            $where[] = 'email LIKE :email';
            $params['email'] = '%' . $request->get('email') . '%';
        }
        if ($request->get('phone')) {
            $where[] = 'phone LIKE :phone';
            $params['phone'] = '%' . $request->get('phone') . '%';
        }
        if ($request->get('address')) {
            $where[] = 'address LIKE :address';
            $params['address'] = '%' . $request->get('address') . '%';
        }

        $where = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $table = $this->repository->getTableName();

        $sql = "SELECT p.* FROM $table p $where ORDER BY $orderBy LIMIT $offset, $limit";

        return $this->repository->query($sql, $params);
    }
}