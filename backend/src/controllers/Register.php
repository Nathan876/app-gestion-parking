<?php

namespace App\controllers;

use App\models\UserModel;

class Register extends Controller {
    protected UserModel $user;

    public function __construct($params) {
        $this->user = new UserModel();
        parent::__construct($params);
    }

    public function postRegister()
    {
        $first_name = $_POST['first_name'] ?? '';
        $last_name = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirmation = $_POST['password_confirmation'] ?? '';
        $birth_date = $_POST['birth_date'] ?? null;
        $phone_number = $_POST['phone_number'] ?? null;
        $license_plate = $_POST['license_plate'] ?? null;

        if (!$first_name || !$last_name || !$email || !$password || !$password_confirmation) {
            header('Location: /frontend/views/register.php?error=missing_fields');
            exit;
        }

        if ($password !== $password_confirmation) {
            header('Location: /frontend/views/register.php?error=password_mismatch');
            exit;
        }

        if ($this->user->getByEmail($email)) {
            header('Location: /frontend/views/register.php?error=email_taken');
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
            header('Location: /frontend/views/register.php?error=failed');
            exit;
        }
        $user = $this->user->getById($newUserId);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name']
        ];

        header('Location: /frontend/views/user/dashboard.php');
        exit;
    }
}