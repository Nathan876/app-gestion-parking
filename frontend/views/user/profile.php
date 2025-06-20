<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du profil - Gestion de Parking</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<main>
    <div>
        <h2>Gestion du profil</h2>

        <div>
            <h3>Informations Personnelles</h3>
            <form id="profile_form">
                <label for="first_name">Prénom :</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="last_name">Nom :</label>
                <input type="text" id="last_name" name="last_name" required>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password">

                <label for="password_confirmation">Mot de passe :</label>
                <input type="password" id="password_confirmation" name="password_confirmation">

                <label for="birth_date">Date de naissance :</label>
                <input type="date" id="birth_date" name="birth_date" required>

                <label for="phone_number">Numéro de téléphone :</label>
                <input type="tel" id="phone_number" name="phone_number" required>

                <label for="license_plate">Plaque d'immatriculation :</label>
                <input type="text" id="license_plate" name="license_plate" required>

                <button type="submit">Mettre à jour</button>
            </form>
            <div id="updateMessage"></div>
        </div>
    </div>
</main>
</body>

<script type="module">
    import { requireAuth } from '../../public/auth.js';
    requireAuth(1);
</script>
<script src="https://js.pusher.com/beams/2.1.0/push-notifications-cdn.js"></script>
<script type="module">
    document.addEventListener('DOMContentLoaded', async () => {
        try {
            const response = await fetch('https://api.trouvetaplace.local/profile', {
                method: 'GET',
                credentials: 'include'
            });

            const user = await response.json();

            document.getElementById('first_name').value = user.first_name;
            document.getElementById('last_name').value = user.last_name;
            document.getElementById('email').value = user.email;
            document.getElementById('birth_date').value = user.birth_date;
            document.getElementById('phone_number').value = user.phone_number ?? '';
            document.getElementById('license_plate').value = user.license_plate ?? '';
        } catch (error) {
            console.error('Erreur chargement profil:', error);
        }
    });

    document.getElementById('profile_form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = {
            first_name: document.getElementById('first_name').value,
            last_name: document.getElementById('last_name').value,
            email: document.getElementById('email').value,
            password: document.getElementById("password").value,
            password_confirmation: document.getElementById("password_confirmation").value,
            birth_date: document.getElementById('birth_date').value,
            phone_number: document.getElementById('phone_number').value,
            license_plate: document.getElementById('license_plate').value,
        };

        try {
            const response = await fetch('https://api.trouvetaplace.local/profile', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (response.ok) {
                document.getElementById('updateMessage').textContent = 'Profil mis à jour avec succès.';
            } else {
                document.getElementById('updateMessage').textContent = result.message || 'Erreur lors de la mise à jour.';
            }
        } catch (error) {
            console.error('Erreur mise à jour:', error);
            document.getElementById('updateMessage').textContent = 'Une erreur est survenue.';
        }
    });
</script>
</html>