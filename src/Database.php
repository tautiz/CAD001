<?php

namespace Appsas;

use PDO;

class Database
{
    private \PDO $pdo;

    public function __construct(private Configs $configs)
    {
        $this->connect();
    }

    private function connect(): void
    {
        $config = $this->configs->configs['db'];
        $dsn = "mysql:host={$config['hostmane']};dbname={$config['dbname']};charset=utf8";
        $this->pdo = new PDO($dsn, $config['username'], $config['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}