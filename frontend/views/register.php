<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion - Gestion de Parking</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
<main class="register-container">
    <section class="register-box">
        <h1 class="login-title">Inscription</h1>
        <div>
            <h2>Créez votre compte</h2>
            <form class="register-form" id="register-form">
                <div id="errors"></div>
                <label for="first_name">Prénom :</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="last_name">Nom :</label>
                <input type="text" id="last_name" name="last_name" required>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>

                <label for="password_confirmation">Mot de passe :</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>

                <label for="birth_date">Date de naissance :</label>
                <input type="date" id="birth_date" name="birth_date">

                <label for="phone_number">Numéro de téléphone :</label>
                <input type="tel" id="phone_number" name="phone_number">

                <label for="license_plate">Plaque d'immatriculation :</label>
                <input type="text" id="license_plate" name="license_plate">

                <button type="submit" name="signup-submit">S'inscrire</button>
            </form>
        </div>
    </section>
</main>
</body>

<script type="module">
    import { register } from '../public/js/register.js';

    document.querySelector('#register-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const first_name = document.querySelector('#first_name').value;
        const last_name = document.querySelector('#last_name').value;
        const email = document.querySelector('#email').value;
        const password = document.querySelector('#password').value;
        const password_confirmation = document.querySelector('#password_confirmation').value;
        const birth_date = document.querySelector('#birth_date').value;
        const phone_number = document.querySelector('#phone_number').value;
        const license_plate = document.querySelector('#license_plate').value;
        const errorsElement = document.querySelector('#errors');
        errorsElement.innerHTML = '';

        try {
            const result = await register(first_name, last_name, email, password, password_confirmation, birth_date, phone_number, license_plate);

            if (result.success) {
                window.location.href = 'https://trouvetaplace.local/views/login.php';
            }

        } catch (err) {
            errorsElement.innerHTML = `<div class="alert alert-danger">Erreur de connexion au serveur</div>`;
        }
    });
</script>
</html>