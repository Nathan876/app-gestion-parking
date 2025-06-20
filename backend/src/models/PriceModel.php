<?php

// src/models/PriceModel.php

namespace App\Models;

use PDO;

class PriceModel extends SqlConnect
{
    public function add(array $data): bool
    {
        $sql = "INSERT INTO prices (parking_id, space_type, start_date, end_date, start_time, end_time, week_day, price_per_hour, priority)
                     VALUES (:parking_id, :space_type, :start_date, :end_date, :start_time, :end_time, :week_day, :price_per_hour, :priority)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM prices ORDER BY priority DESC, start_date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM prices WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    public function update($id, $data): bool
    {
        $sql = "
        UPDATE prices SET 
            price_per_hour = :price_per_hour,
            start_date = :start_date,
            end_date = :end_date,
            start_time = :start_time,
            end_time = :end_time,
            week_day = :week_day,
            priority = :priority
        WHERE id = :id
    ";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'price_per_hour' => $data['price_per_hour'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'week_day' => $data['week_day'],
            'priority' => $data['priority'],
            'id' => $id
        ]);
    }
}
