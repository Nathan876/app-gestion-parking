<?php
// backend/src/models/DataModel.php
namespace App\Models;

use PDO;

class DataModel extends SqlConnect {
    public function getTotalUsers(): int {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE role = 1");
        return (int)$stmt->fetchColumn();
    }

    public function getTodayReservations(): int {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM reservations 
            WHERE DATE(arrival_date) = CURRENT_DATE 
            AND status = 'confirmed'
        ");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getCurrentlyOccupiedSpaces(): int {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM reservations 
            WHERE status = 'confirmed'
            AND DATE(arrival_date) <= CURRENT_DATE 
            AND DATE(departure_date) >= CURRENT_DATE
            AND TIME(arrival_time) <= CURRENT_TIME 
            AND TIME(departure_time) >= CURRENT_TIME
        ");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getTodayRevenue(): float {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(amount), 0) FROM reservations 
            WHERE DATE(arrival_date) = CURRENT_DATE 
            AND status = 'confirmed'
        ");
        $stmt->execute();
        return (float)$stmt->fetchColumn();
    }
}