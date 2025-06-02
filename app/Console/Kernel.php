<?php
namespace BananaPHP\Console;

use BananaPHP\Contracts\Console\Kernel as KernelContract;
use BananaPHP\Foundation\Application;
use Symfony\Component\Console\Application as ConsoleApplication;
use App\Console\Commands\{
    MakeController,
    MakeModel,
    MakeMiddleware,
    MakeMigration,
    MigrateCommand,
    ServeCommand
};

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
        $commands = [
            MakeController::class,
            MakeModel::class,
            MakeMiddleware::class,
            MakeMigration::class,
            MigrateCommand::class,
            ServeCommand::class
        ];

        foreach ($commands as $command) {
            $this->console->add($this->app->make($command));
        }
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
}