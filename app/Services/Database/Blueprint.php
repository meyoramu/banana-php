<?php
declare(strict_types=1);

namespace BananaPHP\Services\Database;

class Blueprint
{
    private string $table;
    private array $columns = [];
    private array $primaryKeys = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function id(string $column = 'id'): void
    {
        $this->columns[] = "{$column} INT AUTO_INCREMENT PRIMARY KEY";
    }

    public function string(string $column, int $length = 255): void
    {
        $this->columns[] = "{$column} VARCHAR({$length})";
    }

    public function integer(string $column): void
    {
        $this->columns[] = "{$column} INT";
    }

    public function timestamp(string $column): void
    {
        $this->columns[] = "{$column} TIMESTAMP";
    }

    public function useCurrent(): void
    {
        $lastColumn = array_pop($this->columns);
        $this->columns[] = "{$lastColumn} DEFAULT CURRENT_TIMESTAMP";
    }

    public function toColumnsSql(): string
    {
        return implode(', ', $this->columns);
    }

    public function toSql(): string
    {
        $columns = $this->toColumnsSql();
        $primaryKeys = $this->primaryKeys ? 
            ', PRIMARY KEY (' . implode(', ', $this->primaryKeys) . ')' : '';
        return "CREATE TABLE {$this->table} ({$columns}{$primaryKeys})";
    }
}