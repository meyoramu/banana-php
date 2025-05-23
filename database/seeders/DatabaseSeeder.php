<?php
declare(strict_types=1);

namespace BananaPHP\Database\Seeders;

use BananaPHP\Services\Database\Connection;
use PDO;

class DatabaseSeeder
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoleSeeder::class
        ]);
    }

    protected function call(array $seeders): void
    {
        foreach ($seeders as $seeder) {
            (new $seeder())->run();
        }
    }
}