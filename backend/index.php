<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/src/Router.php';
header("Access-Control-Allow-Origin: https://trouvetaplace.local");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

// Préflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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
    'users/delete' => \App\controllers\Users::class,
    'reservation' => \App\Controllers\Reservation::class,
    'reservation/:id' => \App\Controllers\Reservation::class,
    'reservations' => \App\Controllers\Reservation::class,
    'parkings/:id' => \App\Controllers\Parkings::class,
    'allreservations/:id' => \App\Controllers\Reservation::class,
    'lastreservation' => \App\Controllers\LastReservation::class,
//    'reservation' => \App\controllers\Reservation::class,
    'login' => \App\controllers\Authentification::class,
    'parking' => Parking::class,
    'parkings' => \App\controllers\Parkings::class,
    'auth/check' => \App\Controllers\Authentification::class,
    'authentification' => \App\Controllers\Authentification::class,
    'reservations/${reservation.id}/status' => \App\Controllers\Reservations::class,
    'auth' => \App\Controllers\Authentification::class,
    'register' => \App\controllers\Register::class,
    'logout' => \App\controllers\Authentification::class,
    'bookings' => \App\Controllers\Bookings::class,
    'profile' => User::class,
    'settings' => \App\Models\Settings::class,
    'pricing' => \App\Controllers\Pricing::class,
];

new \App\Router($router);