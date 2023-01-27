<?php

namespace Appsas\Managers;

use Appsas\Database;
use Appsas\Request;

class PersonsManager extends BaseManager
{
    public function __construct(protected Database $db)
    {
    }

    public function getAll(): array
    {
        return $this->db->query('SELECT p.*, concat(c.title, \' - \', a.city, \' - \', a.street, \' - \', a.postcode) address
                    FROM persons p
                        LEFT JOIN addresses a on p.address_id = a.id 
                        LEFT JOIN countries c on a.country_iso = c.iso');
    }

    public function getOne(int $id): array
    {
        return $this->db->query('SELECT p.*, concat(c.title, \' - \', a.city, \' - \', a.street, \' - \', a.postcode) address
                    FROM persons p
                        LEFT JOIN addresses a on p.address_id = a.id 
                        LEFT JOIN countries c on a.country_iso = c.iso
                    WHERE p.id = :id',
            ['id' => $id])[0];
    }

    public function store(array $data): void
    {
        $this->db->query(
            "INSERT INTO `persons` (`first_name`, `last_name`, `code`, `address_id`, `email`, `phone`)
                    VALUES (:first_name, :last_name, :code, :address_id, :email, :phone)",
            $data
        );
    }

    public function update(array $data): void
    {
        $this->db->query(
            "UPDATE `persons` 
                    SET `first_name` = :first_name, 
                        `last_name` = :last_name, 
                        `code` = :code, 
                        `email` = :email,          
                        `phone` = :phone, 
                        `address_id` = :address_id 
                    WHERE `id` = :id",
            $data
        );
    }

    public function delete(int $id): void
    {
        $this->db->query(
            "DELETE FROM `persons` WHERE `id` = :id",
            ['id' => $id]
        );
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
        return $this->db->query($sql, $params);
    }

    public function getTotal(): int
    {
        return $this->db->query('SELECT COUNT(*) total FROM persons')[0]['total'];
    }
}