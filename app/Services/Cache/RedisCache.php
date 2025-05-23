<?php
declare(strict_types=1);

namespace BananaPHP\Services\Cache;

use Predis\Client;
use BananaPHP\Exceptions\CacheException;

class RedisCache implements CacheInterface
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host'   => env('REDIS_HOST', '127.0.0.1'),
            'port'   => env('REDIS_PORT', 6379),
            'password' => env('REDIS_PASSWORD', null),
            'database' => env('REDIS_CACHE_DB', 1),
        ]);
    }

    public function get(string $key, $default = null)
    {
        try {
            $value = $this->client->get($key);
            return $value !== null ? unserialize($value) : $default;
        } catch (\Exception $e) {
            throw new CacheException('Redis error: ' . $e->getMessage());
        }
    }

    public function set(string $key, $value, int $ttl = null): bool
    {
        try {
            $serialized = serialize($value);
            if ($ttl) {
                return $this->client->setex($key, $ttl, $serialized) === 'OK';
            }
            return $this->client->set($key, $serialized) === 'OK';
        } catch (\Exception $e) {
            throw new CacheException('Redis error: ' . $e->getMessage());
        }
    }

    public function delete(string $key): bool
    {
        try {
            return $this->client->del([$key]) === 1;
        } catch (\Exception $e) {
            throw new CacheException('Redis error: ' . $e->getMessage());
        }
    }

    public function clear(): bool
    {
        try {
            return $this->client->flushdb() === 'OK';
        } catch (\Exception $e) {
            throw new CacheException('Redis error: ' . $e->getMessage());
        }
    }

    public function has(string $key): bool
    {
        try {
            return $this->client->exists($key) === 1;
        } catch (\Exception $e) {
            throw new CacheException('Redis error: ' . $e->getMessage());
        }
    }
}