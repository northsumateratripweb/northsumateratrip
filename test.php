<?php

use Illuminate\Contracts\Console\Kernel;

try {
    require 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $app->make(Kernel::class)->bootstrap();
} catch (Throwable $e) {
    file_put_contents('error_clean.txt', 'ERROR: '.$e->getMessage()."\nFILE: ".$e->getFile().':'.$e->getLine());
}
