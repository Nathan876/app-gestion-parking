<?php

namespace App\Models;

use \PDO;
use stdClass;

class ReservationModel extends SqlConnect {

    public function add(array $data) {
        $query = "
            INSERT INTO reservations (
                user_id, parking_space_id, amount, 
                arrival_date, arrival_time, 
                departure_date, departure_time, 
                status
            ) VALUES (
                :user_id, :parking_space_id, :amount, 
                :arrival_date, :arrival_time, 
                :departure_date, :departure_time, 
                :status
            )
        ";

        $req = $this->db->prepare($query);
        $req->execute($data);
    }

    public function delete(int $id) {
        $req = $this->db->prepare("DELETE FROM reservations WHERE id = :id");
        $req->execute(["id" => $id]);
    }

    public function getPDO(): PDO {
        return $this->db;
    }

    public function get(int $id) {
        $req = $this->db->prepare("SELECT * FROM reservations WHERE id = :id");
        $req->execute(["id" => $id]);

        return $req->rowCount() > 0 ? $req->fetch(PDO::FETCH_ASSOC) : new stdClass();
    }
    public function findAvailableSpace($parking_id, $space_type, $arrival_datetime, $departure_datetime) {
        $query = "
        SELECT ps.id
        FROM parking_spaces ps
        WHERE ps.parking_id = :parking_id
        AND ps.space_type = :space_type
        AND ps.id NOT IN (
            SELECT r.parking_space_id
            FROM reservations r
            WHERE
                (r.arrival_date + INTERVAL TIME_TO_SEC(r.arrival_time) SECOND) < :departure_datetime
                AND (r.departure_date + INTERVAL TIME_TO_SEC(r.departure_time) SECOND) > :arrival_datetime
        )
        LIMIT 1
    ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'parking_id' => $parking_id,
            'space_type' => $space_type,
            'arrival_datetime' => $arrival_datetime,
            'departure_datetime' => $departure_datetime
        ]);

        return $stmt->fetchColumn();
    }

    public function getLast() {
        $req = $this->db->prepare("SELECT * FROM reservations ORDER BY id DESC LIMIT 1");
        $req->execute();

        return $req->rowCount() > 0 ? $req->fetch(PDO::FETCH_ASSOC) : new stdClass();
    }

    public function getAllReservation() {
        $req = $this->db->prepare("SELECT 
  reservations.id,
  reservations.amount,
  reservations.arrival_date,
  reservations.arrival_time,
  reservations.departure_date,
  reservations.departure_time,
  reservations.status,
  reservations.created_at,
  parking_spaces.space_number,
  users.first_name,
  users.last_name,
  parkings.name AS parking_name
FROM reservations
JOIN users ON reservations.user_id = users.id
JOIN parking_spaces ON reservations.parking_space_id = parking_spaces.id
JOIN parkings ON parking_spaces.parking_id = parkings.id
ORDER BY reservations.created_at DESC");
        $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUser(int $userId) {
        $req = $this->db->prepare("SELECT * FROM reservations WHERE user_id = :user_id ORDER BY created_at DESC");
        $req->execute(["user_id" => $userId]);

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

//    public function updateStatus(int $id, string $status) {
//        $req = $this->db->prepare("UPDATE reservations SET status = :status WHERE id = :id");
//        $req->execute([
//            "id" => $id,
//            "status" => $status
//        ]);
//    }

    public function getUserReservations($userId, $limit = 6) {
        $sql = "SELECT r.*, ps.space_number, ps.space_type, p.name as parking_name 
        FROM reservations r
        JOIN parking_spaces ps ON r.parking_space_id = ps.id
        JOIN parkings p ON ps.parking_id = p.id
        WHERE r.user_id = :user_id
        ORDER BY r.created_at DESC
        LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReservationDetails($id) {
        $query = "
        SELECT r.*, ps.space_type, ps.space_number, p.name AS parking_name
        FROM reservations r
        JOIN parking_spaces ps ON r.parking_space_id = ps.id
        JOIN parkings p ON ps.parking_id = p.id
        WHERE r.id = :id
    ";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLastPendingReservation($userId) {
        $query = "
        SELECT r.*, ps.space_type, ps.space_number, p.name AS parking_name
        FROM reservations r
        JOIN parking_spaces ps ON r.parking_space_id = ps.id
        JOIN parkings p ON ps.parking_id = p.id
        WHERE r.user_id = :user_id
        ORDER BY r.created_at DESC
        LIMIT 1
    ";

        $stmt = $this->db->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLastConfirmedReservation($userId) {
        $query = "
        SELECT r.*, ps.space_type, ps.space_number, p.name AS parking_name
        FROM reservations r
        JOIN parking_spaces ps ON r.parking_space_id = ps.id
        JOIN parkings p ON ps.parking_id = p.id
        WHERE r.user_id = :user_id
          AND r.status = 'confirmed'
        ORDER BY r.created_at DESC
        LIMIT 1
    ";

        $stmt = $this->db->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function calculateAmount($parking_id, $space_type, $arrival_datetime, $departure_datetime): float {
        $amount = 0;

        $start = new \DateTime($arrival_datetime);
        $end = new \DateTime($departure_datetime);
        $interval = new \DateInterval('PT1H'); // 1 heure
        $period = new \DatePeriod($start, $interval, $end);

        foreach ($period as $hour) {
            $week_day = $hour->format('l'); // Monday, Tuesday...
            $date = $hour->format('Y-m-d');
            $time = $hour->format('H:i:s');

            $query = "
            SELECT price_per_hour
FROM prices
WHERE parking_id = :parking_id
  AND space_type = :space_type
  AND :date BETWEEN start_date AND end_date
  AND :time BETWEEN start_time AND end_time
  AND (week_day = :week_day OR week_day = 'All')
ORDER BY priority DESC
LIMIT 1;";

            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'parking_id' => $parking_id,
                'space_type' => $space_type,
                'date' => $date,
                'time' => $time,
                'week_day' => $week_day
            ]);

            $price = $stmt->fetchColumn();
            if ($price !== false) {
                $amount += (float)$price;
            }
        }

        return $amount;
    }

    public function getReservationsForSpace(int $spaceId): array {
        $stmt = $this->db->prepare("
        SELECT r.*, u.id as user_id 
        FROM reservations r
        JOIN users u ON r.user_id = u.id
        WHERE r.parking_space_id = :space_id
        AND r.status = 'confirmed'
        AND r.arrival_date >= CURRENT_DATE
    ");

        $stmt->execute(['space_id' => $spaceId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateStatus($reservationId, $status) {
        $stmt = $this->db->prepare("
        UPDATE reservations 
        SET status = ? 
        WHERE id = ?
    ");
        return $stmt->execute([$status, $reservationId]);
    }

    public function getReservationAmount($reservationId) {
        $sql = "SELECT amount FROM reservations WHERE id = ?";
        $stmt = $this->_connexion->prepare($sql);
        $stmt->execute([$reservationId]);
        $result = $stmt->fetch();
        return $result ? $result['amount'] : null;
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE reservations SET 
        arrival_date = :arrival_date,
        arrival_time = :arrival_time,
        departure_date = :departure_date,
        departure_time = :departure_time,
        status = :status
        WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;

        return $stmt->execute($data);
    }
}