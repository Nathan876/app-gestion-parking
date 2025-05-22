<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/src/Router.php';

use App\Router;
use App\controllers\User;
use App\controllers\Login;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$router = new Router([
    'user/:id' => User::class,
    'user' => User::class,
    'login' => Login::class,
    'register' => \App\controllers\Register::class,
    'logout' => \App\controllers\Logout::class,
]);

new \App\Router($router);