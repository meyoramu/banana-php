<?php
namespace BananaPHP;

class Installer
{
    // This runs automatically after installation
    public static function postInstall()
    {
        // On Linux/Mac: make the banana file executable
        if (PHP_OS_FAMILY !== 'Windows') {
            @chmod(__DIR__.'/../../banana', 0755); // 0755 = read/write/execute permissions
        }
        
        // Special setup for Windows
        if (PHP_OS_FAMILY === 'Windows') {
            self::setupWindows();
        }
    }

    // Special setup for Windows computers
    private static function setupWindows()
    {
        // Find where the banana file is
        $target = realpath(__DIR__.'/../../banana');
        
        // Where to put the Windows shortcut
        $link = getenv('APPDATA').'/Composer/vendor/bin/banana.bat';
        
        // Create a Windows batch file that runs banana with PHP
        $batContent = "@ECHO OFF\r\n".      // Hide commands
                      "php \"".$target."\" %*"; // Run banana with PHP
        
        // Save the batch file
        file_put_contents($link, $batContent);
    }
}