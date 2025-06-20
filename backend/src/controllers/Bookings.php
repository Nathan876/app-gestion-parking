<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\ReservationModel;

header("Access-Control-Allow-Origin: https://trouvetaplace.local");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
class Bookings extends Controller {
    protected object $reservation;

    public function __construct($param) {
        $this->reservation = new ReservationModel();
        parent::__construct($param);
    }

    public function postReservation() {
        $data = $this->body;

        $arrival_datetime = $data['arrival_date'] . ' ' . $data['arrival_time'];
        $departure_datetime = $data['departure_date'] . ' ' . $data['departure_time'];

        $available_space_id = $this->reservation->findAvailableSpace(
            $data['parking_id'],
            $data['space_type'],
            $arrival_datetime,
            $departure_datetime
        );

        if (!$available_space_id) {
            echo json_encode(['error' => 'Aucune place disponible pour cette période.']);
            http_response_code(409);
            return;
        }

        $amount = $this->reservation->calculateAmount(
            $data['parking_id'],
            $data['space_type'],
            $arrival_datetime,
            $departure_datetime
        );

        $this->reservation->add([
            'user_id' => $_SESSION['user']['id'],
            'parking_space_id' => $available_space_id,
            'amount' => $amount,
            'arrival_date' => $data['arrival_date'],
            'arrival_time' => $data['arrival_time'],
            'departure_date' => $data['departure_date'],
            'departure_time' => $data['departure_time'],
            'status' => 'pending'
        ]);

        echo json_encode(['success' => true]);
    }

    public function getBookings() {
        $details = $this->reservation->getAllReservation();
        if (!$details) {
            http_response_code(404);
            echo json_encode(['error' => 'Réservation introuvable.']);
            return;
        }
        echo json_encode($details);
    }
}