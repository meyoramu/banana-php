<?php
namespace BananaPHP;

class Installer
{
    public static function postInstall()
    {
        // Make banana executable
        if (PHP_OS_FAMILY !== 'Windows') {
            chmod(__DIR__.'/../../banana', 0755);
        }
        
        // Windows-specific symlink creation
        if (PHP_OS_FAMILY === 'Windows') {
            self::createWindowsSymlink();
        }
        
        echo "\n\033[32mBananaPHP is ready!\033[0m";
        echo "\nTry running: \033[33mbanana migrate\033[0m\n";
    }

    private static function createWindowsSymlink()
    {
        $target = realpath(__DIR__.'/../../banana');
        $link = getenv('APPDATA').'/Composer/vendor/bin/banana';
        
        if (file_exists($link)) {
            @unlink($link);
        }
        
        exec("mklink \"{$link}\" \"{$target}\"", $output, $return);
        
        if ($return !== 0) {
            copy($target, $link);
        }
    }
}