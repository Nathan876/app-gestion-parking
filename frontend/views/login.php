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
<!--        action="/app-gestion-parking/backend/index.php/login" method="POST"-->
        <form  class="login-form" id="login-form" action="/app-gestion-parking/backend/index.php/login" method="POST">
            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" id="email" name="email" required autocomplete="email" />
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" />
                    Se souvenir de moi
                </label>
                <a href="#" class="forgot-link">Mot de passe oublié ?</a>
            </div>

            <button type="submit" name="submit" class="btn-login">Se connecter</button>
        </form>

        <p class="register-link">
            Pas encore de compte ?
            <a href="register.php">Créer un compte</a>
        </p>
    </section>
</main>
</body>
</html>