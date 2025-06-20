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

class Users extends Controller
{
    protected UserModel $user;

    public function __construct($params = [])
    {
        $this->user = new UserModel();
        parent::__construct($params);
    }

    public function getUsers()
    {
        header('Content-Type: application/json');
        echo json_encode($this->user->getAll());
    }

    public function postDelete() {
        header('Content-Type: application/json');

        if (!isset($this->params['user_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID utilisateur manquant']);
            return;
        }

        $userId = intval($this->params['user_id']);
        $success = $this->user->delete($userId);

        if (!$success) {
            http_response_code(404);
            echo json_encode(['error' => 'Utilisateur non trouvé']);
            return;
        }

        echo json_encode(['success' => true, 'message' => 'Utilisateur supprimé avec succès']);
    }
}


