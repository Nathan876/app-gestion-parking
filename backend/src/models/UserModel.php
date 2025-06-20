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

    public function update($data) {
        $sql = "UPDATE users 
            SET first_name = :first_name,
                last_name = :last_name,
                email = :email,
                birth_date = :birth_date,
                phone_number = :phone_number,
                license_plate = :license_plate,
                role = :role
            WHERE id = :id";

        if (!empty($data['password'])) {
            $sql = "UPDATE users 
                SET first_name = :first_name,
                    last_name = :last_name,
                    email = :email,
                    birth_date = :birth_date,
                    phone_number = :phone_number,
                    license_plate = :license_plate,
                    password = :password
                WHERE id = :id";
        }


        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':birth_date', $data['birth_date'], PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $data['phone_number'], PDO::PARAM_STR);
        $stmt->bindParam(':license_plate', $data['license_plate'], PDO::PARAM_STR);
        if ($_SESSION['user']['role'] === 0) {
            $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
        } else {
            $stmt->bindParam(':id', $_SESSION['user']['id'], PDO::PARAM_INT);
        }

        $stmt->bindParam(':role', $data['role'], PDO::PARAM_INT);


        if (!empty($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getById(int $id) {
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
        INSERT INTO users (first_name, last_name, email, password, birth_date, role, phone_number, license_plate)
        VALUES (:first_name, :last_name, :email, :password, :birth_date, 1, :phone_number, :license_plate)
    ");

        $stmt->execute($data);

        return $this->db->lastInsertId();
    }

    public function getByEmail(string $email) {
        $req = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $req->execute(['email' => $email]);
        return $req->rowCount() > 0 ? $req->fetch(PDO::FETCH_ASSOC) : null;
    }

    public function getAll(): array {
        $req = $this->db->prepare("SELECT * FROM users ORDER BY id ASC");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get($userId) {
        $sql = "SELECT id, first_name, last_name, email, birth_date, phone_number, license_plate 
            FROM users 
            WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
