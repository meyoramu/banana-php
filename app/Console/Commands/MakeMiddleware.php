<?php
declare(strict_types=1);

namespace BananaPHP\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RuntimeException;

class MakeMiddleware extends Command
{
    protected static $defaultName = 'make:middleware';
    protected static $defaultDescription = 'Create a new middleware class';

    protected function configure(): void
    {
        $this
            ->setName(self::$defaultName) // Explicitly set the name
            ->setDescription(self::$defaultDescription)
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'The name of the middleware'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $path = $this->getPath($name);

        if (file_exists($path)) {
            $output->writeln('<error>Middleware already exists at: '.$path.'</error>');
            return Command::FAILURE;
        }

        $this->ensureDirectoryExists(dirname($path));

        $stub = $this->getStub();
        $stub = str_replace('{{ class }}', $name, $stub);

        if (file_put_contents($path, $stub) === false) {
            throw new RuntimeException('Failed to write middleware file: '.$path);
        }

        $output->writeln('<info>Middleware created successfully:</info> '.$path);
        return Command::SUCCESS;
    }

    private function getPath(string $name): string
    {
        return __DIR__.'/../../../app/Middleware/'.$name.'.php';
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

namespace App\Middleware;

use BananaPHP\Middleware\MiddlewareInterface;
use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;

class {{ class }} implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // Perform actions before passing to next middleware
        $response = $next($request);
        // Perform actions after getting response
        return $response;
    }
}
STUB;
    }
}