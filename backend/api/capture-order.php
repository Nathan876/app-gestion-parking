<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require_once __DIR__ . '/../classes/PayPalClient.php';

use classes\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

header("Access-Control-Allow-Origin: https://trouvetaplace.local");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['orderID']) || !isset($data['reservation_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'orderID ou reservation_id manquant']);
    exit;
}

$orderID = $data['orderID'];
$reservationId = $data['reservation_id'];

try {
    $client = PayPalClient::client();
    $request = new OrdersCaptureRequest($orderID);
    $request->prefer('return=representation');

    $response = $client->execute($request);

    echo json_encode([
        'status' => 'success',
        'paypal' => $response->result,
        'reservation_id' => $reservationId
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}