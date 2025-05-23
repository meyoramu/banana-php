<?php
declare(strict_types=1);

namespace BananaPHP\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

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
        $consolePath = __DIR__.'/../../bin/banana';
        if (!file_exists($consolePath)) {
            $stub = <<<'STUB'
#!/usr/bin/env php
<?php
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../bootstrap/app.php';

$kernel = new BananaPHP\Console\Kernel();
exit($kernel->handle());
STUB;
            file_put_contents($consolePath, $stub);
            chmod($consolePath, 0755);
        }
    }

    private function registerCommands(): void
    {
        $commands = [
            \BananaPHP\Console\Commands\MakeController::class,
            \BananaPHP\Console\Commands\MakeModel::class,
            \BananaPHP\Console\Commands\MakeMiddleware::class,
            \BananaPHP\Console\Commands\MakeMigration::class,
            \BananaPHP\Console\Commands\MigrateCommand::class,
        ];

        foreach ($commands as $commandClass) {
            if (class_exists($commandClass)) {
                $command = new $commandClass();
                if ($command instanceof Command) {
                    $this->application->add($command);
                }
            }
        }
    }

    public function handle(): int
    {
        return $this->application->run();
    }
}