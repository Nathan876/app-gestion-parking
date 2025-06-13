<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: views/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="./views/styles.css">
</head>
<body>
<div class="container-fluid pt-3">
    <?php include 'views/user/navbar.php'; ?>
    <h1>Bienvenue <?= htmlspecialchars($_SESSION['user']['first_name']) ?></h1>
    <p>Accédez aux fonctionnalités depuis le menu.</p>
</div>
</body>
<script src="https://js.pusher.com/beams/2.1.0/push-notifications-cdn.js"></script>
</html>