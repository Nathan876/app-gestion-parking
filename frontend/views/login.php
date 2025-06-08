<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion - Gestion de Parking</title>
    <link rel="stylesheet" href="styles.css" />
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

        try {
            const result = await login(email, password);

            if (result.success) {
                if (result.role === 0) {
                    window.location.href = '/views/admin/dashboard.php';
                } else {
                    window.location.href = '/views/user/dashboard.php';
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