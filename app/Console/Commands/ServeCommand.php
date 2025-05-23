<?php
declare(strict_types=1);

namespace BananaPHP\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ServeCommand extends Command
{
    protected static $defaultName = 'serve';

    protected function configure(): void
    {
        $this
            ->setDescription('Start the development server')
            ->addOption(
                'port',
                'p',
                InputOption::VALUE_OPTIONAL,
                'The port to serve the application on',
                8000
            )
            ->addOption(
                'host',
                null,
                InputOption::VALUE_OPTIONAL,
                'The host to serve the application on',
                '127.0.0.1'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $host = $input->getOption('host');
        $port = $input->getOption('port');
        
        $output->writeln("<info>BANANA-PHP development server started:</info> http://{$host}:{$port}");
        $output->writeln("<comment>Press Ctrl+C to stop the server</comment>");
        
        passthru(PHP_BINARY . " -S {$host}:{$port} -t public");
        
        return Command::SUCCESS;
    }
}