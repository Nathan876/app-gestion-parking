<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Gestion de Parking</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<main>
    <div>
        <h2>Créez votre compte</h2>
        <form action="" method="post">
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
</main>
</body>
</html>
