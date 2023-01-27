<?php

namespace Appsas\Managers;

use Appsas\Exceptions\ForeignKeyException;
use Appsas\Repositories\PersonsRepository;
use Appsas\Request;
use Appsas\Managers\BaseManager;
use Appsas\Managers\UserManager;
use Appsas\Managers\AddressManager;

class PersonsManager extends BaseManager implements ManagerInterface
{
    private UserManager $userManager;
    private AddressManager $addressManager;

    public function __construct(PersonsRepository $repository, AddressManager $addressManager, UserManager $userManager)
    {
        $this->repository = $repository;
        $this->addressManager = $addressManager;
        $this->userManager = $userManager;
    }

    /**
     * @throws ForeignKeyException
     */
    public function delete(Request $request): void
    {
        $id = $request->get('id');
        $this->userManager->deleteByPersonId($id);
        $this->addressManager->deleteByPersonId($id);
        $this->repository->delete($id);
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
        $sql = "SELECT p.*, CONCAT_WS(' - ', c.title, a.city, a.street, a.postcode) address
                    FROM persons p
                        LEFT JOIN addresses a on p.address_id = a.id
                        LEFT JOIN countries c on a.country_iso = c.iso
                    $where ORDER BY $orderBy LIMIT $offset, $limit";
        return $this->repository->query($sql, $params);
    }

    public function getTotal(): int
    {
        return $this->repository->query('SELECT COUNT(*) total FROM persons')[0]['total'];
    }
}