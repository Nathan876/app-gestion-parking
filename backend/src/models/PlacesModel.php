<?php

namespace App\models;

use PDO;

class PlacesModel extends SqlConnect {
    public function getAll() {
        $stmt = $this->db->query("
        SELECT 
            ps.*, 
            p.name AS parking_name,
            EXISTS (
                SELECT 1
                FROM reservations r
                WHERE r.parking_space_id = ps.id
                  AND r.status = 'pending'
                  AND NOW() BETWEEN 
                      CONCAT(r.arrival_date, ' ', r.arrival_time) 
                      AND 
                      CONCAT(r.departure_date, ' ', r.departure_time)
            ) AS is_occupied
        FROM parking_spaces ps 
        JOIN parkings p ON ps.parking_id = p.id
    ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add(array $data) {
        $stmt = $this->db->prepare("
            INSERT INTO parking_spaces (parking_id, space_number, space_type, is_free)
            VALUES (:parking_id, :space_number, :space_type, :is_free)
        ");
        return $stmt->execute($data);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM parking_spaces WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function update(array $data): bool {
        $stmt = $this->db->prepare("
        UPDATE parking_spaces 
        SET parking_id = :parking_id,
            space_number = :space_number,
            space_type = :space_type
        WHERE id = :id
    ");
        return $stmt->execute($data);
    }
}