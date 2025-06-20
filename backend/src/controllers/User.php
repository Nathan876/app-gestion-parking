<?php

namespace App\controllers;

use App\models\Usermodel;
header('Access-Control-Allow-Origin: https://trouvetaplace.local');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}
class User extends Controller {
    protected object $user;

    public function __construct($param) {
        $this->user = new Usermodel();

        parent::__construct($param);
    }

    public function postUser() {
        $this->user->add($this->body);

        return $this->user->getLast();
    }

    public function deleteUser() {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input['id'])) {
            http_response_code(400);
            return ['error' => 'ID utilisateur manquant'];
        }

        $userId = intval($input['id']);
        $success = $this->user->delete($userId);

        if (!$success) {
            http_response_code(404);
            return ['error' => 'Utilisateur non trouvé'];
        }

        return ['success' => true, 'message' => 'Utilisateur supprimé avec succès'];
    }

    public function getUser() {
        return $this->user->get(intval($this->params['id']));
    }

    public function getProfile() {
        if (!isset($_SESSION['user']['id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Non autorisé']);
            return;
        }

        $userId = $_SESSION['user']['id'];
        $userProfile = $this->user->get($userId);

        if (!$userProfile) {
            http_response_code(404);
            echo json_encode(['error' => 'Profil non trouvé']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($userProfile);
    }

    public function postProfile() {
        $this->user->update($this->body);
        return ['success' => true, 'message' => 'Profil mis à jour avec succès'];
    }

    public function updateSettings() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 0) {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['opening_time']) || !isset($data['closing_time'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        try {
            $stmt = $this->db->prepare('UPDATE settings SET opening_time = ?, closing_time = ?');
            $success = $stmt->execute([$data['opening_time'], $data['closing_time']]);

            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Settings updated']);
            } else {
                throw new \Exception('Failed to update settings');
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function putUser() {

        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input['id'])) {
            http_response_code(400);
            return ['error' => 'ID utilisateur manquant'];
        }

        $userId = intval($input['id']);

        $success = $this->user->update($input);

        if (!$success) {
            http_response_code(404);
            return ['error' => 'Utilisateur non trouvé'];
        }

        return ['success' => true, 'message' => 'Utilisateur supprimé avec succès'];
    }

}
