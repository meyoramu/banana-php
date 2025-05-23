<?php
declare(strict_types=1);

namespace BananaPHP\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use BananaPHP\Services\Database\Migration;
use BananaPHP\Services\Database\Schema;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class MigrateCommand extends Command
{
    protected static $defaultName = 'migrate';

    protected function configure(): void
    {
        $this->setDescription('Run all database migrations');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $migrationsPath = __DIR__.'/../../../database/migrations';
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($migrationsPath));
        
        foreach ($files as $file) {
            if ($file->isDir()) continue;
            
            $className = $this->getClassNameFromFile($file->getPathname());
            require_once $file->getPathname();
            
            if (class_exists($className)) {
                $migration = new $className();
                if ($migration instanceof Migration) {
                    $output->writeln("<info>Migrating:</info> {$className}");
                    $migration->up();
                    $output->writeln("<info>Migrated:</info> {$className}");
                }
            }
        }
        
        $output->writeln('<info>All migrations completed successfully</info>');
        return Command::SUCCESS;
    }

    private function getClassNameFromFile(string $filePath): string
    {
        $contents = file_get_contents($filePath);
        preg_match('/class\s+([^\s]+)\s+/', $contents, $matches);
        return $matches[1] ?? '';
    }
}