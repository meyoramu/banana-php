<?php
declare(strict_types=1);

namespace BananaPHP\Services\Database;

use PDO;
use RuntimeException;

class Connection
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__.'/../../../config/database.php';
            $connection = $config['connections'][$config['default']];

            try {
                self::$instance = new PDO(
                    "{$connection['driver']}:host={$connection['host']};port={$connection['port']};dbname={$connection['database']}",
                    $connection['username'],
                    $connection['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (\PDOException $e) {
                throw new RuntimeException("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}