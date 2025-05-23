<?php
declare(strict_types=1);

namespace BananaPHP\Models;

use BananaPHP\Services\Database\QueryBuilder;

abstract class BaseModel
{
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $hidden = [];

    public static function query(): QueryBuilder
    {
        return (new static())->newQuery();
    }

    protected function newQuery(): QueryBuilder
    {
        $query = new QueryBuilder(Connection::getInstance());
        return $query->table($this->table);
    }

    public static function all(): array
    {
        return static::query()->get();
    }

    public static function find(int $id): ?array
    {
        return static::query()->where((new static())->primaryKey, '=', $id)->first();
    }
}