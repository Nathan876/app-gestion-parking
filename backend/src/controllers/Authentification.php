<?php
namespace App\controllers;

use App\models\UserModel;
use App\Services\NotificationService;

header('Access-Control-Allow-Origin: https://trouvetaplace.local');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

class Authentification extends Controller {
    protected UserModel $user;

    private NotificationService $notification;

    public function __construct($params) {
        $this->user = new UserModel();
        $this->notification = new NotificationService();
        parent::__construct($params);
    }

    public function postAuthentification() {
        $email = $this->body['email'] ?? '';
        $password = $this->body['password'] ?? '';

        $user = $this->user->getByEmail($email);

        if (!$user) {
            http_response_code(401);
            return ['error' => 'Email introuvable'];
        }

        if (!password_verify($password, $user['password'])) {
            http_response_code(401);
            return ['error' => 'Mot de passe incorrect'];
        }

        if ($user['active_account'] === 0) {
            http_response_code(403);
            return ['error' => 'Compte inactif. Veuillez contacter le support.'];
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        return [
            'success' => true,
            'message' => 'Connexion réussie',
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role']
            ]
        ];
    }

    public function getLogout()
    {
        session_destroy();
        return [
            'success' => true,
            'redirect' => 'https://trouvetaplace.local/views/login.php'
        ];
    }

    public function getAuth() {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            return ['authenticated' => false, 'message' => 'Utilisateur non connecté'];
        }

        $user = $_SESSION['user'];

        return [
            'authenticated' => true,
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
    }
}