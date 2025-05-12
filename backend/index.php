<?php


require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
//require '../vendor/autoload.php';

use App\Router;
use App\Controllers\User;

new Router([
    'user/:id' => User::class
]);
