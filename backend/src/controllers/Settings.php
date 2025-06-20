<?php

namespace App\Controllers;

use App\Models\SettingsModel;

header("Access-Control-Allow-Origin: https://trouvetaplace.local");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

class Settings extends Controller
{
    private SettingsModel $settings;

    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->settings = new SettingsModel();
    }

    public function getSettings()
    {
        header('Content-Type: application/json');
        echo json_encode($this->settings->getAll());
    }

    public function postSettings()
    {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Requête invalide']);
            return;
        }

        $keys = ['max_reservation_duration_hours', 'max_advance_booking_days'];
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                $this->settings->update($key, $data[$key]);
            }
        }

        echo json_encode(['success' => true, 'message' => 'Paramètres mis à jour']);
    }
}