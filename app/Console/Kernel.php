<?php
declare(strict_types=1);

namespace BananaPHP\Console;

use Symfony\Component\Console\Application;
use BananaPHP\Console\Commands\MakeController;
use BananaPHP\Console\Commands\MakeModel;
use BananaPHP\Console\Commands\MakeMiddleware;
use BananaPHP\Console\Commands\MigrateCommand;
use BananaPHP\Console\Commands\ServeCommand;

class Kernel
{
    private Application $application;

    public function __construct()
    {
        $this->application = new Application('BANANA-PHP Console', '1.0.0');
        $this->registerCommands();
    }

    public static function postAutoloadDump(): void
    {
        if (!file_exists($console = __DIR__.'/../../bin/banana')) {
            copy(__DIR__.'/../../stubs/console.stub', $console);
            chmod($console, 0755);
        }
    }

    private function registerCommands(): void
    {
        try {
            $commands = [
                MakeController::class,
                MakeModel::class,
                MakeMiddleware::class,
                MigrateCommand::class,
                ServeCommand::class,
            ];

            foreach ($commands as $command) {
                if (class_exists($command)) {
                    $this->application->add(new $command());
                }
            }
        } catch (\Throwable $e) {
            // Silently fail if a command class is missing
        }
    }

    public function handle(): int
    {
        return $this->application->run();
    }
}