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

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->user->getByEmail($email);

        if (!$user) {
            http_response_code(401);
            return ['error' => 'Email introuvable'];
        }

        if (!password_verify($password, $user['password'])) {
            http_response_code(401);
            return ['error' => 'Mot de passe incorrect'];
        }

        $_SESSION['user'] = [
            'message' => 'Connexion réussie',
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name']
            ]
        ];
        if($user['role'] === 0){
            header('Location: ../../frontend/views/admin/dashboard.php');
        } else if ($user['role'] === 1){
            header('Location: ../../frontend/views/user/dashboard.php');
        }
        http_response_code(200);
        exit;
    }
}