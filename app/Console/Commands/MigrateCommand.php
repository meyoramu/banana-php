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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $pdo = Connection::getInstance();
        $migrationsPath = __DIR__.'/../../../database/migrations';
        
        try {
            // Ensure migrations table exists
            $this->ensureMigrationsTableExists($pdo);

            // Get already run migrations
            $runMigrations = $this->getRunMigrations($pdo);

            // Process migration files
            $files = glob($migrationsPath.'/*.php');
            $newMigrations = 0;

            foreach ($files as $file) {
                $migrationName = basename($file, '.php');

                if (!in_array($migrationName, $runMigrations, true)) {
                    require_once $file;
                    $className = $this->getClassNameFromFileName($migrationName);

                    if (class_exists($className)) {
                        $migration = new $className();
                        if ($migration instanceof Migration) {
                            $output->writeln("<comment>Migrating:</comment> {$migrationName}");
                            $migration->up();
                            $this->recordMigration($pdo, $migrationName);
                            $output->writeln("<info>Migrated:</info> {$migrationName}");
                            $newMigrations++;
                        }
                    }
                }
            }

            if ($newMigrations === 0) {
                $output->writeln('<info>Nothing to migrate</info>');
            } else {
                $output->writeln("<info>Migrated {$newMigrations} migrations successfully</info>");
            }

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln("<error>Migration failed: {$e->getMessage()}</error>");
            return Command::FAILURE;
        }
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