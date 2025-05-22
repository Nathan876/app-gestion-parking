<?php

namespace App\models;

use PDO;
use stdClass;

class UserModel extends SqlConnect {
    public function add(array $data) {
        $query = "
        INSERT INTO users (last_name, first_name, email, password, birth_date, role, phone_number, license_plate)
        VALUES (:last_name, :first_name, :email, :password, :birth_date, :role, :phone_number, :license_plate)
      ";

        $req = $this->db->prepare($query);
        $req->execute($data);
    }

    public function delete(int $id) {
        $req = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $req->execute(["id" => $id]);
    }

    public function get(int $id) {
        $req = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $req->execute(["id" => $id]);

        return $req->rowCount() > 0 ? $req->fetch(PDO::FETCH_ASSOC) : new stdClass();
    }

    public function getLast() {
        $req = $this->db->prepare("SELECT * FROM users ORDER BY id DESC LIMIT 1");
        $req->execute();

        return $req->rowCount() > 0 ? $req->fetch(PDO::FETCH_ASSOC) : new stdClass();
    }

    public function create(array $data): ?int
    {
        $stmt = $this->db->prepare("
        INSERT INTO users (first_name, last_name, email, password, birth_date, phone_number, license_plate)
        VALUES (:first_name, :last_name, :email, :password, :birth_date, :phone_number, :license_plate)
    ");

        $stmt->execute($data);

        return $this->pdo->lastInsertId();
    }

    public function getByEmail(string $email) {
        $req = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $req->execute(['email' => $email]);
        return $req->rowCount() > 0 ? $req->fetch(PDO::FETCH_ASSOC) : null;
    }
}
