<?php
declare(strict_types=1);

namespace BananaPHP\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use BananaPHP\Services\Database\Connection;
use BananaPHP\Services\Database\Migration;
use PDO;
use RuntimeException;

class MigrateCommand extends Command
{
    protected static $defaultName = 'migrate';
    protected static $defaultDescription = 'Run the database migrations';

    protected function configure(): void
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription(self::$defaultDescription);
    }

    private function ensureMigrationsTableExists(PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    private function getRunMigrations(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function recordMigration(PDO $pdo, string $migrationName): void
    {
        $stmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $stmt->execute([$migrationName]);
    }

    private function getClassNameFromFileName(string $fileName): string
    {
        $parts = explode('_', $fileName);
        array_shift($parts); // Remove timestamp
        return implode('', array_map('ucfirst', $parts));
    }
}