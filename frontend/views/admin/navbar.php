<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Utilisateur</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<nav class="navbar">
    <button class="navbar-toggle" aria-label="Menu" onclick="toggleMenu()">
        <span class="hamburger"></span>
    </button>
    <div class="navbar-logo">
        <a href="dashboard.php">
            <img src="../../public/images/logo.png" alt="Logo Trouve ta place" class="site-logo">
        </a>
    </div>
    <div class="navbar-links">
        <a href="bookings.php">Réservations</a>
        <a href="parkings.php">Parkings</a>
        <a href="parking.php">Places</a>
        <a href="pricing.php">Tarifs</a>
        <a href="reports.php">Résultats</a>
        <a href="users.php">Utilisateurs</a>
        <a href="settings.php">Réglages</a>
        <a onclick="handleLogout()">Déconnexion</a>
    </div>
</nav>
</body>
<script type="module">
    import { logout } from '../../public/js/logout.js';
    window.handleLogout = () => {
        logout();
    };
</script>
<script>
    function toggleMenu() {
        const links = document.querySelector('.navbar-links');
        links.classList.toggle('show');
    }
</script>
</html>
