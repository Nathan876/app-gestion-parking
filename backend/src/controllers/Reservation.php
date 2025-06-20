<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\ReservationModel;
use App\Services\NotificationService;
use App\Models\SettingsModel;

class Reservation extends Controller {
    protected object $reservation;
    private NotificationService $notification;
    private SettingsModel $settings;

    public function __construct($param) {
        header("Access-Control-Allow-Origin: https://trouvetaplace.local");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
        $this->reservation = new ReservationModel();
        $this->settings = new SettingsModel($this->reservation->getPDO());
        $this->notification = new NotificationService();
        parent::__construct($param);
    }

    public function postReservation() {
        $data = $this->body;

        $arrival = $data['arrival_date'] . ' ' . $data['arrival_time'];
        $departure = $data['departure_date'] . ' ' . $data['departure_time'];

        $arrivalDT = new \DateTime($arrival);
        $departureDT = new \DateTime($departure);
        $now = new \DateTime();

        $settings = $this->settings->getAll();

        $maxHours = isset($settings['max_reservation_duration_hours']) ? (int)$settings['max_reservation_duration_hours'] : 24;
        $maxDaysAdvance = isset($settings['max_advance_booking_days']) ? (int)$settings['max_advance_booking_days'] : 7;

        if ($arrivalDT >= $departureDT) {
            http_response_code(400);
            echo json_encode(['error' => 'La date d\'arrivée doit être avant la date de départ.']);
            return;
        }

        if ($arrivalDT < $now) {
            http_response_code(400);
            echo json_encode(['error' => 'La date d\'arrivée doit être dans le futur.']);
            return;
        }

        $duration = $departureDT->getTimestamp() - $arrivalDT->getTimestamp();
        $durationHours = $duration / 3600;

        error_log("Durée calculée : $durationHours heures, Limite autorisée : $maxHours heures");

        if ($durationHours > $maxHours) {
            http_response_code(400);
            echo json_encode(['error' => 'La réservation dépasse la durée maximale autorisée.' . $durationHours. ' Maximum: ' . $maxHours . ' heures.']);
            return;
        }

        $daysInAdvance = $now->diff($arrivalDT)->days;
        if ($daysInAdvance > $maxDaysAdvance) {
            http_response_code(400);
            echo json_encode(['error' => 'La réservation est trop éloignée dans le futur.']);
            return;
        }

        $available_space_id = $this->reservation->findAvailableSpace(
            $data['parking_id'],
            $data['space_type'],
            $arrival,
            $departure
        );

        if (!$available_space_id) {
            http_response_code(409);
            echo json_encode(['error' => 'Aucune place disponible pour cette période.']);
            return;
        }

        $amount = $this->reservation->calculateAmount(
            $data['parking_id'],
            $data['space_type'],
            $arrival,
            $departure
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

    public function getReservation() {
        $id = $_SESSION['user']['user']['id'];
        $details = $this->reservation->getReservationDetails($id);
        if (!$details) {
            http_response_code(404);
            echo json_encode(['error' => 'Réservation introuvable.']);
            return;
        }
        echo json_encode($details);
    }



    public function getReservations() {
        if (!isset($_SESSION['user']['id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Non autorisé']);
            return;
        }

        $userId = $_SESSION['user']['id'];
        $reservations = $this->reservation->getUserReservations($userId, 1000);

        echo json_encode($reservations ?: []);
    }

    public function updateStatus($reservationId, $status) {
        $stmt = $this->pdo->prepare("UPDATE reservations SET status = :status xWHERE id = :reservationId");
        $this->notification->send_notification("user_" . $_SESSION['user']['id'], "Votre réservation" . $reservationId . " a été mise à jour avec le statut : " . $status);
        return $stmt->execute([$status, $reservationId]);
    }

    public function deleteReservation() {
        header('Content-Type: application/json');

        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || empty($body['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de réservation manquant']);
            return;
        }

        $model = new \App\Models\ReservationModel();
        $model->delete((int) $body['id']);

        echo json_encode(['success' => true, 'message' => 'Réservation supprimée']);
    }

    public function getAllReservations() {
        if (!isset($_SESSION['user']['user']['id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Non autorisé']);
            return;
        }

        $userId = $_SESSION['user']['user']['id'];
        $reservations = $this->reservation->getUserReservations($userId, 1000);

        echo json_encode($reservations ?: []);
    }

    public function putReservation() {
        header('Content-Type: application/json');

        $body = json_decode(file_get_contents('php://input'), true);

        if (!$body || empty($body['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de réservation manquant']);
            return;
        }

        $id = $body['id'];

        if (!empty($body['status'])) {
            $success = $this->updateStatus((int) $id, $body['status']);
        } else {
            $required = ['arrival_date', 'arrival_time', 'departure_date', 'departure_time', 'status'];
            foreach ($required as $field) {
                if (empty($body[$field])) {
                    http_response_code(400);
                    echo json_encode(['error' => "Champ requis manquant : $field"]);
                    return;
                }
            }

            $model = new \App\Models\ReservationModel();
            $success = $model->update($id, [
                'arrival_date' => $body['arrival_date'],
                'arrival_time' => $body['arrival_time'],
                'departure_date' => $body['departure_date'],
                'departure_time' => $body['departure_time'],
                'status' => $body['status']
            ]);
        }

        if ($success) {
            $reservation = $model->getReservationDetails($id);
            echo json_encode([
                'success' => true,
                'message' => 'Réservation mise à jour',
                'reservation' => $reservation
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la mise à jour']);
        }
    }
}