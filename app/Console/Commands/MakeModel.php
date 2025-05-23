<?php
declare(strict_types=1);

namespace BananaPHP\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
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
                'The name of the model (e.g. User)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $path = $this->getPath($name);

        if (file_exists($path)) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion(
                "Model {$name} already exists. Overwrite? (y/n) ",
                false
            );

            if (!$helper->ask($input, $output, $question)) {
                $output->writeln('<comment>Operation canceled.</comment>');
                return Command::SUCCESS;
            }
        }

        $this->ensureDirectoryExists(dirname($path));

        $stub = $this->getStub();
        $stub = str_replace(
            ['{{ class }}', '{{ table }}'],
            [$name, $this->getTableName($name)],
            $stub
        );

        if (file_put_contents($path, $stub) === false) {
            throw new RuntimeException("Failed to create model at: {$path}");
        }

        $output->writeln("<info>Model created successfully:</info> {$path}");
        return Command::SUCCESS;
    }

    private function getPath(string $name): string
    {
        return __DIR__.'/../../../app/Models/'.$name.'.php';
    }

    private function getTableName(string $name): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name)).'s';
    }

    private function ensureDirectoryExists(string $path): void
    {
        if (!is_dir($path) && !mkdir($path, 0755, true) && !is_dir($path)) {
            throw new RuntimeException("Directory {$path} was not created");
        }
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