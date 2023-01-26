<?php

namespace Appsas\Managers;

use Appsas\Database;

class PersonsManager
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

// TODO: Velesniam Filtravimui
//
//                        ' . $searchQuery . '
//                        ORDER BY ' . $orderBy . ' DESC LIMIT ' . $kiekis,
//            $params);
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
}