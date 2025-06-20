<?php

namespace App\Controllers;

use App\Models\DataModel;

class Data extends Controller {
    private DataModel $data;
    public function __construct($params) {
        $this->data = new DataModel();
        parent::__construct($params);
    }

    public function getStats() {
        header('Content-Type: application/json');

        try {
            $stats = [
                'totalUsers' => $this->data->getTotalUsers(),
                'todayReservations' => $this->data->getTodayReservations(),
                'occupiedSpaces' => $this->data->getCurrentlyOccupiedSpaces(),
                'todayRevenue' => $this->data->getTodayRevenue()
            ];

            echo json_encode($stats);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la récupération des statistiques']);
        }
        exit;
    }
}