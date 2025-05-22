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
            <h3>Horaires d'Ouverture</h3>
            <form id="openingHoursForm">
                <div class="settings-form">
                    <label for="parking_id">Parking :</label>
                    <select id="parking_id" name="parking_id" required>
                        <option value="">Sélectionnez un parking</option>
                        <option value="1">Parking Centre-Ville</option>
                        <option value="2">Parking Gare</option>
                    </select>

                    <label for="weekday_open">Heure d'Ouverture (Jours de Semaine) :</label>
                    <input type="time" id="weekday_open" name="weekday_open" required>

                    <label for="weekday_close">Heure de Fermeture (Jours de Semaine) :</label>
                    <input type="time" id="weekday_close" name="weekday_close" required>

                    <label for="weekend_open">Heure d'Ouverture (Week-end) :</label>
                    <input type="time" id="weekend_open" name="weekend_open" required>

                    <label for="weekend_close">Heure de Fermeture (Week-end) :</label>
                    <input type="time" id="weekend_close" name="weekend_close" required>
                </div>
                <button type="button" onclick="saveOpeningHours()">Enregistrer</button>
            </form>
        </div>

        <div class="settings-section">
            <h3>Paramètres Système</h3>
            <form id="systemSettingsForm">
                <div class="settings-form">
                    <label for="max_booking_duration">Durée Maximale de Réservation (heures) :</label>
                    <input type="number" id="max_booking_duration" name="max_booking_duration" min="1" required>

                    <label for="booking_cancellation_threshold">Délai d'Annulation (heures) :</label>
                    <input type="number" id="booking_cancellation_threshold" name="booking_cancellation_threshold" min="1" required>

                    <label for="notification_email">Email de Notification :</label>
                    <input type="email" id="notification_email" name="notification_email" required>
                </div>
                <button type="button">Enregistrer</button>
            </form>
        </div>
    </div>
</main>
</body>
</html>
