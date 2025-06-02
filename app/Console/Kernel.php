<?php
namespace BananaPHP\Console;

use BananaPHP\Contracts\Console\Kernel as KernelContract;
use BananaPHP\Foundation\Application;
use Symfony\Component\Console\Application as ConsoleApplication;

class Kernel implements KernelContract
{
    private ConsoleApplication $console;
    private Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->console = new ConsoleApplication('BANANA-PHP', '1.0.0');
    }

    public function handle(): int
    {
        $this->registerCommands();
        return $this->console->run();
    }

    private function registerCommands(): void
    {
        $commandMap = [
            'make:controller' => \BananaPHP\Console\Commands\MakeController::class,
            'make:model' => \BananaPHP\Console\Commands\MakeModel::class,
            'make:middleware' => \BananaPHP\Console\Commands\MakeMiddleware::class,
            'make:migration' => \BananaPHP\Console\Commands\MakeMigration::class,
            'migrate' => \BananaPHP\Console\Commands\MigrateCommand::class,
            'serve' => \BananaPHP\Console\Commands\ServeCommand::class
        ];

        foreach ($commandMap as $name => $class) {
            try {
                if (!class_exists($class)) {
                    throw new \RuntimeException("Command class {$class} not found");
                }
                
                $command = $this->app->make($class);
                $this->console->add($command);
                
            } catch (\Exception $e) {
                error_log("Command registration failed for {$name}: " . $e->getMessage());
                // Continue with other commands even if one fails
            }
        }
    }

    public static function postAutoloadDump(): void
    {
        $consolePath = __DIR__.'/../../banana';
        if (!file_exists($consolePath)) {
            file_put_contents($consolePath, <<<'STUB'
#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

$app = new BananaPHP\Foundation\Application(__DIR__);
$kernel = $app->make(BananaPHP\Contracts\Console\Kernel::class);
exit($kernel->handle());
STUB
            );
            chmod($consolePath, 0755);
        }
    }
}