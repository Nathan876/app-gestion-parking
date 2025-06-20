<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Réserver une place - Gestion de Parking</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<main>
  <div>
    <h2>Réserver une place de parking</h2>
    <form id="reservationForm">
      <label for="parking_id">Choisissez le parking :</label>
      <select id="parking_id" name="parking_id" required>
        <option value="">Sélectionnez un parking</option>
      </select>

      <label for="space_type">Type de place :</label>
      <select id="space_type" name="space_type" required>
        <option value="">Sélectionnez un type de place</option>
        <option value="0">Standard</option>
        <option value="1">Handicapé</option>
        <option value="2">Moto</option>
        <option value="3">Vélo</option>
      </select>

      <label for="arrival_date">Date d'arrivée :</label>
      <input type="date" id="arrival_date" name="arrival_date" required>

      <label for="arrival_time">Heure d'arrivée :</label>
      <input type="time" id="arrival_time" name="arrival_time" required>

      <label for="departure_date">Date de départ :</label>
      <input type="date" id="departure_date" name="departure_date" required>

      <label for="departure_time">Heure de départ :</label>
      <input type="time" id="departure_time" name="departure_time" required>

      <button type="submit">Réserver</button>
    </form>
  </div>
</main>
</body>
<script src="https://js.pusher.com/beams/2.1.0/push-notifications-cdn.js"></script>
<script type="module">
    import { requireAuth } from '../../public/auth.js';
    const data =requireAuth(1);

    document.addEventListener('DOMContentLoaded', async () => {
        const parkingSelect = document.getElementById('parking_id');

        try {
            const response = await fetch('https://api.trouvetaplace.local/parkings', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const parkings = await response.json();

            parkingSelect.innerHTML = '<option value="">Sélectionnez un parking</option>';

            parkings.forEach(parking => {
                const option = document.createElement('option');
                option.value = parking.id;
                option.textContent = parking.name;
                parkingSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Erreur lors de la récupération des parkings:', error);
            parkingSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        }
    });
    document.querySelector('#reservationForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const userId = data.id;

        const startDateTime = `${form.arrival_date.value} ${form.arrival_time.value}:00`;
        const endDateTime = `${form.departure_date.value} ${form.departure_time.value}:00`;

        try {
            const response = await fetch('https://api.trouvetaplace.local/reservation', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify({
                    parking_id: parseInt(form.parking_id.value),
                    space_type: parseInt(form.space_type.value),
                    arrival_date: form.arrival_date.value,
                    arrival_time: form.arrival_time.value,
                    departure_date: form.departure_date.value,
                    departure_time: form.departure_time.value,

                    parking_space_id: null,
                    amount: 0,
                    status: 'pending'
                })
            });
            const result = await response.json();

            if (response.ok) {
                window.location.href = `https://trouvetaplace.local/views/user/paypal.php`;
                console.log(result);
            } else {
                alert('Erreur lors de la réservation : ' + (result.error || response.statusText));
            }
        } catch (err) {
            console.log(err)
            console.error(err);
            alert('Une erreur est survenue.');
        }
    });
</script>
</html>
