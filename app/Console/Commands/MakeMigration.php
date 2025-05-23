<?php
declare(strict_types=1);

namespace BananaPHP\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RuntimeException;
use DateTime;

class MakeMigration extends Command
{
    protected static $defaultName = 'make:migration';
    protected static $defaultDescription = 'Create a new migration file';

    protected function configure(): void
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription(self::$defaultDescription)
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'The name of the migration (e.g. CreateUsersTable)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $timestamp = (new DateTime())->format('Y_m_d_His');
        $fileName = "{$timestamp}_{$name}.php";
        $path = $this->getPath($fileName);

        if (file_exists($path)) {
            $output->writeln("<error>Migration already exists at: {$path}</error>");
            return Command::FAILURE;
        }

        $this->ensureDirectoryExists(dirname($path));

        $stub = $this->getStub();
        $stub = str_replace(
            ['{{ className }}', '{{ tableName }}'],
            [$this->getClassName($name), $this->getTableName($name)],
            $stub
        );

        if (file_put_contents($path, $stub) === false) {
            throw new RuntimeException("Failed to create migration at: {$path}");
        }

        $output->writeln("<info>Migration created successfully:</info> {$path}");
        return Command::SUCCESS;
    }

    private function getPath(string $fileName): string
    {
        return __DIR__.'/../../../database/migrations/'.$fileName;
    }

    private function ensureDirectoryExists(string $path): void
    {
        if (!is_dir($path) && !mkdir($path, 0755, true) && !is_dir($path)) {
            throw new RuntimeException("Directory {$path} was not created");
        }
    }

    private function getClassName(string $name): string
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', $name);
    }

    private function getTableName(string $name): string
    {
        if (preg_match('/create_(\w+)_table/i', $name, $matches)) {
            return $matches[1];
        }
        if (preg_match('/add_(\w+)_to_(\w+)_table/i', $name, $matches)) {
            return $matches[2];
        }
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
    }

    private function getStub(): string
    {
        return <<<'STUB'
<?php
declare(strict_types=1);

use BananaPHP\Services\Database\Migration;
use BananaPHP\Services\Database\Schema;

class {{ className }} extends Migration
{
    public function up(): void
    {
        $this->schema->createTable('{{ tableName }}', function ($table) {
            $table->id();
            // Add your columns here
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        $this->schema->dropTableIfExists('{{ tableName }}');
    }
}
STUB;
    }
}