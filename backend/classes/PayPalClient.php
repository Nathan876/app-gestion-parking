<?php

namespace classes;
require_once __DIR__ . '/../../vendor/autoload.php';

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use Dotenv\Dotenv;

class PayPalClient
{
    public static function client(): PayPalHttpClient
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        if (!isset($_ENV['CLIENT_ID']) || !isset($_ENV['CLIENT_SECRET'])) {
            throw new \RuntimeException('PayPal credentials not found in .env file');
        }

        $clientId = $_ENV['CLIENT_ID'];
        $clientSecret = $_ENV['CLIENT_SECRET'];

        $environment = new SandboxEnvironment($clientId, $clientSecret);
        return new PayPalHttpClient($environment);
    }
}