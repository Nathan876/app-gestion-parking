<?php

namespace App\models;

use PDO;

class ParkingModel extends SqlConnect
{
    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT * FROM parkings
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add(array $data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO parkings (name, address, city, postal_code, total_capacity)
            VALUES (:name, :address, :city, :postal_code, :total_capacity)
        ");
        return $stmt->execute($data);
    }

    public function update(array $data)
    {
        $stmt = $this->db->prepare("UPDATE parkings SET name = :name, address = :address, city = :city, postal_code = :postal_code WHERE id = :id");
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM parkings WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function getById(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM parkings WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}