<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement PayPal - Trouve ta place</title>
    <link rel="stylesheet" href="../../views/styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main>
    <h2>Paiement sécurisé</h2>

    <div class="stats-card">
        <div id="reservation-details"></div>

        <div id="paypal-button-container"></div>
    </div>
</main>

<script type="module">
    import { requireAuth } from '../../public/auth.js';
    await requireAuth(1);
</script>

<script src="https://www.paypal.com/sdk/js?client-id=AZ5opfGgwwWZUmso6Apfvnqew9XZXawrJwajH86_VQw_ULc2P8DDHe8kQF9YHIPvA6-J4qfYP2JfwiIb&currency=EUR&locale=fr_FR"></script>

<script>
    async function getReservation() {
        try {
            const response = await fetch(`https://api.trouvetaplace.local/lastreservation`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include'
            });

            if (!response.ok) {
                throw new Error('Erreur lors de la récupération de la réservation');
            }

            return await response.json();
        } catch (error) {
            console.error('Erreur:', error);
            throw error;
        }
    }


    document.addEventListener('DOMContentLoaded', async () => {
        try {
            const reservation = await getReservation();

            document.getElementById('reservation-details').innerHTML = `
                    <h3>Détails de votre réservation</h3>
                    <table>
                        <tr>
                            <td>Montant total</td>
                            <td>${reservation.amount} €</td>
                        </tr>
                        <tr>
                            <td>Date d'arrivée</td>
                            <td>${reservation.arrival_date} ${reservation.arrival_time}</td>
                        </tr>
                        <tr>
                            <td>Date de départ</td>
                            <td>${reservation.departure_date} ${reservation.departure_time}</td>
                        </tr>
                    </table>
                `;

            paypal.Buttons({
                createOrder: async function() {
                    const response = await fetch("https://api.trouvetaplace.local/api/create-order.php", {
                        method: 'POST',
                        credentials: 'include',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            amount: reservation.amount,
                            reservation_id: reservation.id
                        })
                    });
                    const data = await response.json();
                    return data.orderID;
                },
                onApprove: async function(data) {
                    const response = await fetch("https://api.trouvetaplace.local/api/capture-order.php", {
                        method: 'POST',
                        credentials: 'include',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            reservation_id: reservation.id
                        })
                    });
                    const details = await response.json();
                    window.location.href = 'https://trouvetaplace.local/views/user/booking-confirmation.php';
                }
            }).render('#paypal-button-container');

        } catch (error) {
            document.getElementById('reservation-details').innerHTML = `
                    <div class="modal-content">
                        Une erreur est survenue: ${error.message}
                    </div>
                `;
        }
    });
</script>
</body>
</html>