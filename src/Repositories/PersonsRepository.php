<?php

namespace Appsas\Repositories;

class PersonsRepository extends BaseRepository implements RepositoryInterface
{
    public function create(array $data): void
    {
        $this->db->query(
            "INSERT INTO `persons` (`first_name`, `last_name`, `code`, `address_id`, `email`, `phone`)
                    VALUES (:first_name, :last_name, :code, :address_id, :email, :phone)",
            $data
        );
    }

    public function findById(int $id): array
    {
        return $this->db->query('SELECT p.* FROM persons p WHERE p.id = :id', ['id' => $id])[0];
    }

    public function findFullPerson(int $id): array
    {
        return $this->db->query('SELECT p.*, CONCAT_WS(\' - \', c.title, a.city, a.street, a.postcode) address
                    FROM persons p
                        LEFT JOIN addresses a on p.address_id = a.id 
                        LEFT JOIN countries c on a.country_iso = c.iso
                    WHERE p.id = :id',
            ['id' => $id])[0];
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

    public function findAll(): array
    {


        return $this->db->query('SELECT p.*, CONCAT_WS(\' - \', c.title, a.city, a.street, a.postcode) address
                    FROM persons p
                        LEFT JOIN addresses a on p.address_id = a.id 
                        LEFT JOIN countries c on a.country_iso = c.iso');
    }
}