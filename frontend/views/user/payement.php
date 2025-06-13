<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement de Réservation - Gestion de Parking</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<main>
    <div>
        <h2>Paiement de votre réservation</h2>
        <form action="" method="post">
            <div>
                <h3>Détails de la Réservation</h3>
                <p><strong>Parking :</strong> Nom du Parking</p>
                <p><strong>Type de Place :</strong> Type de Place</p>
                <p><strong>Numéro de Place :</strong> Numéro de Place</p>
                <p><strong>Date d'Arrivée :</strong> Date d'Arrivée</p>
                <p><strong>Heure d'Arrivée :</strong> Heure d'Arrivée</p>
                <p><strong>Date de Départ :</strong> Date de Départ</p>
                <p><strong>Heure de Départ :</strong> Heure de Départ</p>
                <p><strong>Montant Total :</strong> Montant €</p>
            </div>

            <div>
                <h3>Informations de Paiement</h3>
                <label for="card_number">Numéro de carte :</label>
                <input type="text" id="card_number" name="card_number" required>

                <label for="expiry_date">Date d'expiration :</label>
                <input type="month" id="expiry_date" name="expiry_date" required>

                <label for="cvv">CVV :</label>
                <input type="text" id="cvv" name="cvv" required>

                <button type="submit">Payer</button>
            </div>
        </form>
    </div>
</main>

</body>
<script type="module">
    import { requireAuth } from '../../public/auth.js';
    requireAuth(1);
</script>
</html>
