<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres Système - Admin</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<main>
    <div>
        <h2>Paramètres Système</h2>

        <div class="settings-section">
            <h3>Paramètres Système</h3>
            <form id="systemSettingsForm">
                <div class="settings-form">
                    <label for="max_booking_duration">Durée Maximale de Réservation (heures) :</label>
                    <input type="number" id="max_booking_duration" name="max_booking_duration" min="1" required>

                    <label for="booking_cancellation_threshold">Délai d'Annulation (heures) :</label>
                    <input type="number" id="booking_cancellation_threshold" name="booking_cancellation_threshold" min="1" required>
                </div>
                <button type="button" onclick="saveSystemSettings()">Enregistrer</button>
            </form>
        </div>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        try {
            const res = await fetch('https://api.trouvetaplace.local/settings', {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'include'
            });
            const settings = await res.json();

            document.getElementById('max_booking_duration').value = settings.max_reservation_duration_hours;
            document.getElementById('booking_cancellation_threshold').value = settings.max_advance_booking_days;
        } catch (e) {
            alert("Erreur lors du chargement des paramètres.");
        }
    });

    async function saveSystemSettings() {
        const maxDuration = document.getElementById('max_booking_duration').value;
        const cancelDelay = document.getElementById('booking_cancellation_threshold').value;

        const response = await fetch('https://api.trouvetaplace.local/settings', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify({
                max_reservation_duration_hours: maxDuration,
                max_advance_booking_days: cancelDelay
            })
        });

        const result = await response.json();
        if (result.success) {
            alert('Paramètres mis à jour');
        } else {
            alert(result.error || 'Erreur lors de la mise à jour');
        }
    }
</script>
</body>
</html>
