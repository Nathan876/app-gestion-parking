<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\models\ReservationModel;

header("Access-Control-Allow-Origin: https://trouvetaplace.local");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

class LastReservation extends Controller {
    protected object $reservation;

    public function __construct($param) {
        parent::__construct($param);
        $this->reservation = new ReservationModel();
    }

    public function getLastReservation() {
        if (!isset($_SESSION["user"]) || !isset($_SESSION["user"]["id"])) {
            http_response_code(401);
            echo json_encode(['error' => 'Non autorisé']);
            return;
        }

        $details = $this->reservation->getLastPendingReservation($_SESSION["user"]["id"]);
        $this->reservation->updateStatus($_SESSION["user"]["id"], 'confirmed');
        if (!$details) {
            http_response_code(404);
            echo json_encode(['error' => 'Réservation introuvable']);
            return;
        }

       echo json_encode($details);
    }

}