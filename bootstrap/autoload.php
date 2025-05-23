<?php
declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

spl_autoload_register(function ($class) {
    $baseDir = __DIR__.'/../app/';
    $file = $baseDir.str_replace('\\', '/', $class).'.php';
    
    if (file_exists($file)) {
        require $file;
    }
});