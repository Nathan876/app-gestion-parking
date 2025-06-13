<?php

namespace App\controllers;

class Logout extends Controller
{
    public function getLogout()
    {
        session_destroy();

        header('Location: https://trouvetaplace.local/views/login.php');
        exit;
    }
}