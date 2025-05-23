<?php
declare(strict_types=1);

namespace BananaPHP\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RuntimeException;

class MakeController extends Command
{
    protected static $defaultName = 'make:controller';
    protected static $defaultDescription = 'Create a new controller class';

    protected function configure(): void
    {
        $this->addArgument(
            'name',
            InputArgument::REQUIRED,
            'The name of the controller (e.g. "User" or "Admin/User")'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $className = $this->getClassName($name);
        $namespace = $this->getNamespace($name);
        $path = $this->getPath($name);

        if (file_exists($path)) {
            $output->writeln('<error>Controller already exists at: '.$path.'</error>');
            return Command::FAILURE;
        }

        if (!is_dir(dirname($path))) {
            if (!mkdir(dirname($path), 0755, true)) {
                throw new RuntimeException('Failed to create directory: '.dirname($path));
            }
        }

        $stub = $this->getStub();
        $stub = str_replace(['{{ namespace }}', '{{ class }}'], [$namespace, $className], $stub);

        if (file_put_contents($path, $stub) === false) {
            throw new RuntimeException('Failed to write controller file: '.$path);
        }

        $output->writeln('<info>Controller created successfully:</info> '.$path);
        return Command::SUCCESS;
    }

    private function getClassName(string $name): string
    {
        return str_contains($name, '/') 
            ? substr(strrchr($name, '/'), 1)
            : $name;
    }

    private function getNamespace(string $name): string
    {
        $baseNamespace = 'App\\Controllers';
        
        if (str_contains($name, '/')) {
            $subNamespace = str_replace('/', '\\', substr($name, 0, strrpos($name, '/')));
            return $baseNamespace.'\\'.$subNamespace;
        }
        
        return $baseNamespace;
    }

    private function getPath(string $name): string
    {
        $basePath = __DIR__.'/../../../app/Controllers/';
        $name = str_replace('\\', '/', $name);
        return $basePath.$name.'.php';
    }

    private function getStub(): string
    {
        return <<<'STUB'
<?php
declare(strict_types=1);

namespace {{ namespace }};

use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;
use BananaPHP\Services\View\View;

class {{ class }} extends \BananaPHP\Controllers\BaseController
{
    // Example action method
    public function index(): Response
    {
        return $this->view('template_name', [
            'data' => 'example'
        ]);
    }
}
STUB;
    }
}