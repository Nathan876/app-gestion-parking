<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/src/Router.php';


use App\Router;
use App\controllers\User;
use App\controllers\Login;
use App\controllers\Parking;
use App\controllers\Parkings;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$router = [
    'user/:id' => \App\controllers\User::class,
    'user' => User::class,
    'users' => \App\controllers\Users::class,
    'reservation' => \App\Controllers\Reservation::class,
    'reservation/:id' => \App\Controllers\Reservation::class,
    'reservations' => \App\Controllers\Reservation::class,
    'lastreservation' => \App\Controllers\LastReservation::class,
//    'reservation' => \App\controllers\Reservation::class,
    'login' => \App\controllers\Authentification::class,
    'parking' => Parking::class,
    'parkings' => Parkings::class,
    'auth/check' => \App\Controllers\Authentification::class,
    'authentification' => \App\Controllers\Authentification::class,
    'auth' => \App\Controllers\Authentification::class,
    'register' => \App\controllers\Register::class,
    'logout' => \App\controllers\Authentification::class,
    'bookings' => \App\Controllers\Bookings::class,
];

new \App\Router($router);