<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion - Gestion de Parking</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://js.pusher.com/beams/2.1.0/push-notifications-cdn.js"></script>
</head>
<body>
<main class="login-container">
    <section class="login-box">
        <h1 class="login-title">Connexion</h1>
        <form class="login-form" id="login-form">
            <div id="errors"></div>
            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" id="email" name="email" required autocomplete="email">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <div class="form-group">
                <a href="https://trouvetaplace.local/views/register.php">Créer un compte</a>
            </div>
            <button type="submit" class="btn-login">Se connecter</button>
        </form>
    </section>
</main>
</body>
<script type="module">
    import { login } from '../public/js/login.js';

    document.querySelector('#login-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.querySelector('#email').value;
        const password = document.querySelector('#password').value;
        const errorsElement = document.querySelector('#errors');
        errorsElement.innerHTML = '';

        const permission = await Notification.requestPermission();
        if (permission !== 'granted') {
            errorsElement.innerHTML = `<div class="alert alert-danger">Notifications refusées</div>`;
            return;
        }

        try {
            const result = await login(email, password);
            console.log(result.success)
            if (result.success) {
                if (result.user.role === 0) {
                    window.location.href = 'https://trouvetaplace.local/views/admin/dashboard.php';
                } else {
                    window.location.href = 'https://trouvetaplace.local/views/user/dashboard.php';
                }
            } else {
                errorsElement.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
            }
        } catch (err) {
            errorsElement.innerHTML = `<div class="alert alert-danger">Erreur de connexion au serveur</div>`;
        }
    });
</script>
</html>