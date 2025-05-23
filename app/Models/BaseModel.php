<?php
declare(strict_types=1);

namespace BananaPHP\Models;

use BananaPHP\Services\Database\QueryBuilder;
use BananaPHP\Services\Database\Connection;

abstract class BaseModel
{
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $hidden = [];
    protected QueryBuilder $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder(Connection::getInstance());
        $this->queryBuilder->table($this->table);
    }

    public static function query(): QueryBuilder
    {
        $model = new static();
        return $model->queryBuilder;
    }

    public static function all(): array
    {
        return static::query()->get();
    }

    public static function find(int $id): ?array
    {
        return static::query()->where((new static())->primaryKey, '=', $id)->first();
    }

    public static function create(array $data): int
    {
        $model = new static();
        $filteredData = array_intersect_key($data, array_flip($model->fillable));
        return static::query()->insert($filteredData);
    }

    public static function update(int $id, array $data): int
    {
        $model = new static();
        $filteredData = array_intersect_key($data, array_flip($model->fillable));
        return static::query()
            ->where($model->primaryKey, '=', $id)
            ->update($filteredData);
    }

    public static function delete(int $id): int
    {
        $model = new static();
        return static::query()
            ->where($model->primaryKey, '=', $id)
            ->delete();
    }
}