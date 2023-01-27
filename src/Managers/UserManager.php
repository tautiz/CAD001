<?php

namespace Appsas\Managers;

use Appsas\Repositories\UsersRepository;

class UserManager extends BaseManager implements ManagerInterface
{
    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }
}