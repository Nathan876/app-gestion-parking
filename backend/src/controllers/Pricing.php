<?php

namespace App\Controllers;

use App\Models\PriceModel;

header("Access-Control-Allow-Origin: https://trouvetaplace.local");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

class Pricing extends Controller
{
    private PriceModel $model;

    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->model = new PriceModel();
    }

    public function getPricing()
    {
        header('Content-Type: application/json');
        echo json_encode($this->model->getAll());
    }

    public function postPricing()
    {
        header('Content-Type: application/json');
        $body = json_decode(file_get_contents('php://input'), true);

        $required = [
            'parking_id', 'space_type', 'start_date', 'end_date',
            'start_time', 'end_time', 'week_day', 'price_per_hour', 'priority'
        ];

        foreach ($required as $field) {
            if (empty($body[$field]) && $body[$field] !== "0") {
                http_response_code(400);
                echo json_encode(['error' => "Champ requis manquant : $field"]);
                return;
            }
        }

        $success = $this->model->add($body);
        echo json_encode(['success' => $success]);
    }

    public function deletePricing()
    {
        header('Content-Type: application/json');
        $body = json_decode(file_get_contents('php://input'), true);
        $id = $body['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID manquant']);
            return;
        }

        $success = $this->model->delete((int) $id);
        echo json_encode(['success' => $success]);
    }
    public function putPricing()
    {
        header('Content-Type: application/json');
        $body = json_decode(file_get_contents('php://input'), true);
        $id = $body['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID manquant']);
            return;
        }

        $required = ['price_per_hour', 'start_date', 'end_date', 'start_time', 'end_time', 'week_day', 'priority'];
        foreach ($required as $field) {
            if (!isset($body[$field])) {
                http_response_code(400);
                echo json_encode(['error' => "Champ manquant : $field"]);
                return;
            }
        }

        $success = $this->model->update($id, $body);
        echo json_encode(['success' => $success]);
    }
}