<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;
foreach(Product::all() as $p) {
    echo "ID: {$p->id}, Name: {$p->name}, Image: '{$p->featured_image}'" . PHP_EOL;
}
