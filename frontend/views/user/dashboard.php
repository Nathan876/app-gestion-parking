<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord utilisateur - Gestion de Parking</title>
  <link rel="stylesheet" href="../styles.css">
    <script src="https://js.pusher.com/beams/2.1.0/push-notifications-cdn.js"></script>
</head>
<body>
<?php include 'navbar.php'; ?>
<main>
  <div>
    <h2>Bienvenue</h2>
    <div>
      <h3>Vos Réservations</h3>
      <div id="upcoming_reservations">
        <h4>Réservations à venir</h4>
        <ul>
          <li>
            <strong>Place :</strong> A12
            <strong>Date :</strong> 10 octobre 2025
            <strong>Heure :</strong> 14:00 - 16:00
            <button onclick="cancelReservation('ID')">Annuler</button>
          </li>
        </ul>
      </div>
      <div id="past_reservations">
        <h4>Réservations passées</h4>
        <ul>
          <li>
            <strong>Place :</strong> B05
            <strong>Date :</strong> 5 octobre 2025
            <strong>Heure :</strong> 09:00 - 11:00
          </li>
        </ul>
      </div>
    </div>
</main>
</body>
<script type="module">
    import { requireAuth } from '../../public/auth.js';
    requireAuth(1);
</script>
<script src="https://js.pusher.com/beams/2.1.0/push-notifications-cdn.js"></script>
<script>
    const beamsClient = new PusherPushNotifications.Client({
        instanceId: '8b16b2b6-56f2-4951-a346-421c0a38f58d',
    });

    beamsClient.start()
        .then(() => beamsClient.addDeviceInterest('Bonjour'))
        .catch(console.error);
</script>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const upcomingReservations = document.getElementById('upcoming_reservations');
        const pastReservations = document.getElementById('past_reservations');

        try {
            const response = await fetch('https://api.trouvetaplace.local/reservations', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include'
            });


            if (!response.ok) {
                throw new Error('Erreur lors de la récupération des réservations');
            }

            const reservations = await response.json();

            const now = new Date();
            const upcoming = reservations.filter(r => new Date(`${r.departure_date} ${r.departure_time}`) > now);
            const past = reservations.filter(r => new Date(`${r.departure_date} ${r.departure_time}`) <= now);

            upcomingReservations.innerHTML = `
            <h4>Réservations à venir</h4>
            <ul>
                ${upcoming.slice(0, 3).map(res => `
                    <li>
                        <strong>Place :</strong> ${res.space_number}
                        <strong>Date :</strong> ${formatDate(res.arrival_date)}
                        <strong>Heure :</strong> ${formatTime(res.arrival_time)} - ${formatTime(res.departure_time)}
                    </li>
                `).join('')}
            </ul>
        `;

            pastReservations.innerHTML = `
            <h4>Réservations passées</h4>
            <ul>
                ${past.slice(0, 3).map(res => `
                    <li>
                        <strong>Place :</strong> ${res.space_number}
                        <strong>Date :</strong> ${formatDate(res.arrival_date)}
                        <strong>Heure :</strong> ${formatTime(res.arrival_time)} - ${formatTime(res.departure_time)}
                    </li>
                `).join('')}
            </ul>
        `;

        } catch (error) {
            console.error('Erreur:', error);
            upcomingReservations.innerHTML = '<div class="error">Impossible de charger les réservations</div>';
            pastReservations.innerHTML = '';
        }
    });

    function formatDate(dateStr) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateStr).toLocaleDateString('fr-FR', options);
    }

    function formatTime(timeStr) {
        return timeStr.slice(0, 5);
    }
</script>
</html>
