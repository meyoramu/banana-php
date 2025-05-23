<?php
declare(strict_types=1);

namespace BananaPHP\Console;

use Symfony\Component\Console\Application;
use BananaPHP\Console\Commands\MakeController;
use BananaPHP\Console\Commands\MakeModel;
use BananaPHP\Console\Commands\MakeMiddleware;
use Symfony\Component\Console\Command\Command;

class Kernel
{
    private Application $application;

    public function __construct()
    {
        $this->application = new Application('BANANA-PHP Console', '1.0.0');
        $this->registerCommands();
    }

    private function registerCommands(): void
    {
        $commands = [
            new MakeController(),
            new MakeModel(),
            new MakeMiddleware(),
        ];

        foreach ($commands as $command) {
            if ($command instanceof Command) {
                $this->application->add($command);
            }
        }
    }

    public function handle(): int
    {
        return $this->application->run();
    }
}