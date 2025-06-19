<?php

namespace App\controllers;

use App\models\UserModel;
header('Access-Control-Allow-Origin: https://trouvetaplace.local');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}
class Register extends Controller {
    protected UserModel $user;

    public function __construct($params) {
        $this->user = new UserModel();
        parent::__construct($params);
    }

    public function postRegister()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $first_name = $data['first_name'] ?? '';
        $last_name = $data['last_name'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $password_confirmation = $data['password_confirmation'] ?? '';
        $birth_date = $data['birth_date'] ?? null;
        $phone_number = $data['phone_number'] ?? null;
        $license_plate = $data['license_plate'] ?? null;

        if (!$first_name || !$last_name || !$email || !$password || !$password_confirmation) {
            http_response_code(400);
            echo json_encode(['error' => 'missing_fields']);
            exit;
        }

        if ($password !== $password_confirmation) {
            http_response_code(400);
            echo json_encode(['error' => 'password_mismatch']);
            exit;
        }

        if ($this->user->getByEmail($email)) {
            http_response_code(409);
            echo json_encode(['error' => 'email_taken']);
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $newUserId = $this->user->create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $hashedPassword,
            'birth_date' => $birth_date,
            'phone_number' => $phone_number,
            'license_plate' => $license_plate,
        ]);

        if (!$newUserId) {
            http_response_code(500);
            echo json_encode(['error' => 'user_creation_failed']);
            exit;
        }
        $user = $this->user->getById($newUserId);

//        $_SESSION['user'] = [
//            'id' => $user['id'],
//            'email' => $user['email'],
//            'first_name' => $user['first_name'],
//            'last_name' => $user['last_name']
//        ];

        http_response_code(200);
        echo json_encode(['success' => true]);
        exit;
    }
}