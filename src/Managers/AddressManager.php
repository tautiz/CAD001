<?php

namespace Appsas\Managers;

use Appsas\Repositories\AddressRepository;

class AddressManager extends BaseManager implements ManagerInterface
{
    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }
}