<?php
declare(strict_types=1);

namespace BananaPHP\Services\Database;

use PDO;
use RuntimeException;

class Schema
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createTable(string $table, callable $callback): void
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        $this->pdo->exec($blueprint->toSql());
    }

    public function createTableIfNotExists(string $table, callable $callback): void
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        $sql = "CREATE TABLE IF NOT EXISTS {$table} (" . $blueprint->toColumnsSql() . ")";
        $this->pdo->exec($sql);
    }

    public function dropTableIfExists(string $table): void
    {
        $this->pdo->exec("DROP TABLE IF EXISTS {$table}");
    }
}