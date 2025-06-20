<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../classes/PayPalClient.php';
use classes\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

header("Access-Control-Allow-Origin: https://trouvetaplace.local");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$reservationId = $data['reservation_id'] ?? null;
$amount = $data['amount'] ?? null;

if (!$reservationId) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de réservation manquant']);
    exit;
}

try {
    $client = PayPalClient::client();
    $request = new OrdersCreateRequest();
    $request->prefer('return=representation');
    $request->body = [
        "intent" => "CAPTURE",
        "purchase_units" => [[
            "amount" => [
                "currency_code" => "EUR",
                "value" => $amount
            ],
            "custom_id" => $reservationId
        ]]
    ];

    $response = $client->execute($request);
    echo json_encode(['orderID' => $response->result->id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}