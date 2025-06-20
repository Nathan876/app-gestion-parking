<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin - Gestion de Parking</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<main>
    <div>
        <h2>Tableau de bord Administrateur</h2>

        <div class="stats">
            <h3>Statistiques</h3>
            <div class="stats-card">
                <h4>Utilisateurs Totaux</h4>
                <p id="totalUsers">Nombre d'utilisateurs</p>
            </div>
            <div class="stats-card">
                <h4>Réservations Actives</h4>
                <p id="activeBookings">Nombre de réservations actives</p>
            </div>
            <div class="stats-card">
                <h4>Places Occupées</h4>
                <p id="occupiedSpaces">Nombre de places occupées</p>
            </div>
            <div class="stats-card">
                <h4>Revenu Total</h4>
                <p id="totalRevenue">Revenu total €</p>
            </div>
        </div>
    </div>
</main>
</body>
<script type="module">
    import { requireAuth } from '../../public/auth.js';
    requireAuth(0);
</script>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        try {
            const response = await fetch('https://api.trouvetaplace.local/stats', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include'
            });

            if (!response.ok) {
                throw new Error('Erreur réseau');
            }

            const stats = await response.json();

            document.getElementById('totalUsers').textContent = stats.totalUsers;
            document.getElementById('activeBookings').textContent = stats.todayReservations;
            document.getElementById('occupiedSpaces').textContent = stats.occupiedSpaces;
            document.getElementById('totalRevenue').textContent = `${stats.todayRevenue} €`;

        } catch (error) {
            console.error('Erreur:', error);
            document.querySelectorAll('.stats-card p').forEach(p => {
                p.textContent = 'Erreur de chargement';
            });
        }
    });
</script>
</html>
