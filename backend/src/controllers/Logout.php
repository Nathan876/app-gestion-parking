<?php

namespace App\controllers;

class Logout extends Controller
{
    public function getLogout()
    {
        session_destroy();

        header('Location: /app-gestion-parking/frontend/views/login.php');
        exit;
    }
}