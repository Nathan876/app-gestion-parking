<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Réservations - Gestion de Parking</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<main>
    <div>
        <h2>Historique des Réservations</h2>
        <div>
            <table class="reservations-table">
                <thead>
                <tr>
                    <th>Parking</th>
                    <th>Place</th>
                    <th>Type</th>
                    <th>Arrivée</th>
                    <th>Départ</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="bookingHistory">
                <tr>
                    <td colspan="8">Chargement des réservations...</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script type="module">
    import { requireAuth } from '../../public/auth.js';
    requireAuth(1);
</script>
<script src="https://js.pusher.com/beams/2.1.0/push-notifications-cdn.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const bookingHistory = document.getElementById('bookingHistory');

        try {
            const response = await fetch('https://api.trouvetaplace.local/reservations', {
                method: 'GET',
                credentials: 'include',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error('Erreur lors de la récupération des réservations');

            const reservations = await response.json();

            if (reservations.length === 0) {
                bookingHistory.innerHTML = `
                    <tr>
                        <td colspan="8">Aucune réservation trouvée.</td>
                    </tr>
                `;
                return;
            }

            bookingHistory.innerHTML = reservations.map(res => {
                const status = getStatus(res);
                const canCancel = (status === 'En cours');
                return `
                    <tr>
                        <td>${res.parking_name}</td>
                        <td>${res.space_number}</td>
                        <td>${typeToText(res.space_type)}</td>
                        <td>${formatDate(res.arrival_date)} ${res.arrival_time}</td>
                        <td>${formatDate(res.departure_date)} ${res.departure_time}</td>
                        <td>${parseFloat(res.amount).toFixed(2)} €</td>
                        <td>${status}</td>
                        <td>
                            ${canCancel ?
                    `<button class="btn-cancel" onclick="cancelReservation(${res.id})">
                                    Annuler
                                </button>` :
                    ''
                }
                        </td>
                    </tr>
                `;
            }).join('');

        } catch (error) {
            console.error(error);
            bookingHistory.innerHTML = `
                <tr>
                    <td colspan="8">Impossible de charger les réservations.</td>
                </tr>
            `;
        }
    });

    async function cancelReservation(id) {
        if (!confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) return;

        try {
            const response = await fetch(`https://api.trouvetaplace.local/reservation`, {
                method: 'PUT',
                credentials: 'include',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ id: id, status: 'cancelled' })
            });

            if (!response.ok) throw new Error('Erreur lors de l\'annulation');

            location.reload();
        } catch (error) {
            console.error(error);
            alert('Impossible d\'annuler la réservation');
        }
    }

    function formatDate(dateStr) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateStr).toLocaleDateString('fr-FR', options);
    }

    function typeToText(type) {
        return ['Standard', 'Handicapé', 'Moto', 'Vélo'][type] ?? 'Inconnu';
    }

    function getStatus(reservation) {
        const now = new Date();
        const departureDate = new Date(`${reservation.departure_date} ${reservation.departure_time}`);

        if (now > departureDate) {
            return 'Terminée';
        } else {
            return 'En cours';
        }
    }
</script>
</html>