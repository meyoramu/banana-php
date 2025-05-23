<?php
declare(strict_types=1);

namespace BananaPHP\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RuntimeException;

class MakeModel extends Command
{
    protected static $defaultName = 'make:model';
    protected static $defaultDescription = 'Create a new model class';

    protected function configure(): void
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription(self::$defaultDescription)
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'The name of the model'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $path = $this->getPath($name);

        if (file_exists($path)) {
            $output->writeln("<error>Model already exists at: {$path}</error>");
            return Command::FAILURE;
        }

        if (!is_dir(dirname($path))) {
            if (!mkdir(dirname($path), 0755, true)) {
                throw new RuntimeException("Failed to create directory: " . dirname($path));
            }
        }

        $stub = $this->getStub();
        $stub = str_replace(
            ['{{ class }}', '{{ table }}'],
            [$name, strtolower($name) . 's'],
            $stub
        );

        if (file_put_contents($path, $stub) === false) {
            throw new RuntimeException("Failed to write model file: {$path}");
        }

        $output->writeln("<info>Model created successfully:</info> {$path}");
        return Command::SUCCESS;
    }

    private function getPath(string $name): string
    {
        return __DIR__ . '/../../../app/Models/' . $name . '.php';
    }

    private function getStub(): string
    {
        return <<<'STUB'
<?php
declare(strict_types=1);

namespace App\Models;

use BananaPHP\Models\BaseModel;

class {{ class }} extends BaseModel
{
    protected string $table = '{{ table }}';
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $hidden = [];
}
STUB;
    }
}