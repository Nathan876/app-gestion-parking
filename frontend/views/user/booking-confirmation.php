<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Réservation - Gestion de Parking</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<main>
    <div>
        <h2>Confirmation de Réservation</h2>
        <p>Votre réservation a été effectuée avec succès !</p>

        <div id="reservation-details">
            <h3>Détails de la Réservation</h3>
            <p id="parking"><strong>Parking :</strong> <span></span></p>
            <p id="space-type"><strong>Type de Place :</strong> <span></span></p>
            <p id="space-number"><strong>Numéro de Place :</strong> <span></span></p>
            <p id="arrival-date"><strong>Date d'Arrivée :</strong> <span></span></p>
            <p id="arrival-time"><strong>Heure d'Arrivée :</strong> <span></span></p>
            <p id="departure-date"><strong>Date de Départ :</strong> <span></span></p>
            <p id="departure-time"><strong>Heure de Départ :</strong> <span></span></p>
            <p id="amount"><strong>Montant :</strong> <span></span></p>
        </div>
        <p>Merci d'avoir utilisé notre service de gestion de parking !</p>

        <a href="dashboard.php" class="button">Retourner au Tableau de Bord</a>
    </div>
</main>

<script type="module">
    import { requireAuth } from '../../public/auth.js';
    const authentification = requireAuth(1);
</script>
<script src="https://js.pusher.com/beams/2.1.0/push-notifications-cdn.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        try {
            const response = await fetch('https://api.trouvetaplace.local/lastreservation', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include'
            });

            if (!response.ok) {
                throw new Error('Erreur lors de la récupération des données');
            }

            const data = await response.json();

            document.querySelector('#parking span').textContent = data.parking_name;
            document.querySelector('#space-type span').textContent = getTypeLabel(data.space_type);
            document.querySelector('#space-number span').textContent = data.space_number;
            document.querySelector('#arrival-date span').textContent = data.arrival_date;
            document.querySelector('#arrival-time span').textContent = data.arrival_time;
            document.querySelector('#departure-date span').textContent = data.departure_date;
            document.querySelector('#departure-time span').textContent = data.departure_time;
            document.querySelector('#amount span').textContent = `${data.amount} €`;

        } catch (error) {
            console.error('Erreur:', error);
            document.getElementById('reservation-details').innerHTML = `
                <div class="error">Impossible de charger les détails de la réservation</div>
            `;
        }
    });

    function getTypeLabel(type) {
        const types = {
            0: 'Standard',
            1: 'Handicapé',
            2: 'Moto',
            3: 'Vélo'
        };
        return types[parseInt(type)] || 'Inconnu';
    }
</script>
</body>
</html>