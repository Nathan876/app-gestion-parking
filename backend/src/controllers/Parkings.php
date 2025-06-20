<?php

namespace App\controllers;

use App\models\ParkingModel;
use App\models\PlacesModel;

header('Access-Control-Allow-Origin: https://trouvetaplace.local');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}
class Parkings extends Controller {
    protected ParkingModel $parking;

    public function __construct($params) {
        $this->parking = new ParkingModel();
        parent::__construct($params);
    }

    public function getParkings()
    {
        header('Content-Type: application/json');
        echo json_encode($this->parking->getAll());
        exit;
    }

    public function postParkings()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['name'], $data['address'], $data['city'], $data['postal_code'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        $success = $this->parking->add([
            'name' => $data['name'],
            'address' => $data['address'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'total_capacity' => 0
        ]);

        if ($success) {
            http_response_code(201);
            echo json_encode(['message' => 'Parking créé avec succès']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la création du parking']);
        }
    }

    public function deleteParkings() {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        $userId = $data['id'] ?? null;

        if (!$userId || !is_numeric($userId)) {
            http_response_code(400);
            echo json_encode(['error' => 'user_id invalide ou manquant']);
            exit;
        }

        $deleted = $this->parking->delete((int)$userId);

        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Aucun parking trouvé pour cet id ou déjà supprimé']);
        }
        exit;
    }

    public function putParkings()
    {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['id'], $data['formData']['name'], $data['formData']['address'], $data['formData']['city'], $data['formData']['postal_code'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Données invalides']);
            return;
        }

        $success = $this->parking->update([
            'id' => $data['id'],
            'name' => $data['formData']['name'],
            'address' => $data['formData']['address'],
            'city' => $data['formData']['city'],
            'postal_code' => $data['formData']['postal_code']
        ]);

        if ($success) {
            echo json_encode(['message' => 'Parking modifié avec succès']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la modification']);
        }
    }
}