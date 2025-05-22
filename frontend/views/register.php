<div>
    <h2>Créez votre compte</h2>
    <form class="register-form" id="register-form" action="/app-gestion-parking/backend/index.php/register" method="POST">
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