<?php
/**
 * @var object $appLogger
 */
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {

    $pdo = new PDO(
        'mysql:host=' . $_ENV['BDD_URL'] . ';dbname=' . $_ENV['BDD_NAME'] . ';port=' . $_ENV['BDD_PORT'],
        $_ENV['BDD_USERNAME'],
        $_ENV['BDD_PASSWORD']
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {

    $appLogger->alert('Database connection error: ' . $e->getMessage(), [
        'file' => __FILE__,
    ]);

    echo "Erreur de connexion à la base de données.";
}
?>