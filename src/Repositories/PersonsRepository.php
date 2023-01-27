<?php

namespace Appsas\Repositories;

class PersonsRepository extends BaseRepository implements RepositoryInterface
{
    protected const TABLE_NAME = 'persons';

    public function query(string $sql, array $params = []): array
    {
        return $this->db->query($sql, $params);
    }
}