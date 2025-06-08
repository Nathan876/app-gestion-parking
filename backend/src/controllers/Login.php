<?php

namespace App\controllers;

use App\models\UserModel;

class Login extends Controller {
    protected UserModel $user;

    public function __construct($params) {
        $this->user = new UserModel();
        parent::__construct($params);
    }

    public function postLogin()
    {
        header('Content-Type: application/json');
        session_start();

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->user->getByEmail($email);

        if (!$user) {
            http_response_code(401);
            echo json_encode(['errors' => ['Email introuvable']]);
        }

        if (!password_verify($password, $user['password'])) {
            http_response_code(401);
            echo json_encode(['errors' => ['Mot de passe incorrect']]);
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'role' => $user['role']
        ];

        echo json_encode([
            'authentication' => true,
            'role' => $user['role']
        ]);
        http_response_code(200);
    }
}