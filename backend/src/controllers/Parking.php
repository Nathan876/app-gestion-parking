<?php

namespace App\controllers;

use App\models\PlacesModel;
use App\controllers\Controller;
use App\models\ReservationModel;

class Parking extends Controller {

    protected PlacesModel $places;
    protected ReservationModel $reservations;

    public function __construct($params) {
        $this->places = new PlacesModel();
        $this->reservations = new ReservationModel();
        parent::__construct($params);
    }

    public function getList() {
        header('Content-Type: application/json');
        echo json_encode($this->places->getAll());
        exit;
    }
    public function getParking() {
        header('Content-Type: application/json');
        echo json_encode($this->places->getAll());
        exit;
    }

    public function postParking() {
        $data = [
            'parking_id' => $_POST['parking_id'] ?? '',
            'space_number' => $_POST['space_number'] ?? '',
            'space_type' => $_POST['space_type'] ?? '',
            'is_free' => 1,
        ];
        $this->places->add($data);
        http_response_code(200);
        echo json_encode(['message' => 'Place ajoutée avec succès']);
        exit;
    }

    public function deleteParking() {
        header('Content-Type: application/json');

        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || empty($body['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de la place manquant']);
            return;
        }

        $affectedReservations = $this->reservations->getReservationsForSpace($body['id']);

        $deleted = $this->places->delete((int) $body['id']);

        if ($deleted) {
            foreach ($affectedReservations as $reservation) {
                $this->notification->send_notification(
                    "user_" . $reservation['user_id'],
                    "Réservation annulée : Votre réservation a été annulée car la place de parking n'est plus disponible."
                );

                $this->reservations->updateStatus($reservation['id'], 'cancelled');
            }

            echo json_encode(['message' => 'Place supprimée et utilisateurs notifiés']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Place non trouvée ou déjà supprimée']);
        }

        exit;
    }

    public function putParking() {
        $data = json_decode(file_get_contents('php://input'), true);

        $updateData = [
            'id' => $data['id'] ?? null,
            'parking_id' => $data['parking_id'] ?? '',
            'space_number' => $data['space_number'] ?? '',
            'space_type' => $data['space_type'] ?? ''
        ];

        if (!$updateData['id']) {
            http_response_code(400);
            echo json_encode(['error' => 'ID manquant']);
            return;
        }

        $success = $this->places->update($updateData);

        if ($success) {
            echo json_encode(['message' => 'Place modifiée avec succès']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la modification']);
        }
        exit;
    }
}