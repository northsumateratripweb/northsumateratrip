<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

$users = User::all(['id', 'username', 'email', 'name']);
echo 'Total Users: '.$users->count().PHP_EOL;
foreach ($users as $user) {
    echo "ID: {$user->id} | Username: '{$user->username}' | Email: '{$user->email}' | Name: '{$user->name}'".PHP_EOL;
}
