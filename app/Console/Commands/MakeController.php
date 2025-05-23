<?php
declare(strict_types=1);

namespace BananaPHP\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeController extends Command
{
    protected static $defaultName = 'make:controller';

    protected function configure(): void
    {
        $this
            ->setDescription('Create a new controller class')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the controller');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $className = $this->getClassName($name);
        $namespace = $this->getNamespace($name);
        $path = $this->getPath($name);

        if (file_exists($path)) {
            $output->writeln("<error>Controller already exists!</error>");
            return Command::FAILURE;
        }

        $stub = file_get_contents(__DIR__.'/../../../stubs/controller.stub');
        $stub = str_replace(['{{ namespace }}', '{{ class }}'], [$namespace, $className], $stub);

        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        file_put_contents($path, $stub);

        $output->writeln("<info>Controller created successfully: $path</info>");
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
            return $baseNamespace . '\\' . $subNamespace;
        }
        
        return $baseNamespace;
    }

    private function getPath(string $name): string
    {
        $basePath = __DIR__.'/../../../app/Controllers/';
        $name = str_replace('\\', '/', $name);
        return $basePath . $name . '.php';
    }
}