<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Réservation - Gestion de Parking</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<main>
    <div>
        <h2>Confirmation de Réservation</h2>
        <p>Votre réservation a été effectuée avec succès !</p>

        <div>
            <h3>Détails de la Réservation</h3>
            <p><strong>Parking :</strong> Nom du Parking</p>
            <p><strong>Type de Place :</strong> Type de Place</p>
            <p><strong>Numéro de Place :</strong> Numéro de Place</p>
            <p><strong>Date d'Arrivée :</strong> Date d'Arrivée</p>
            <p><strong>Heure d'Arrivée :</strong> Heure d'Arrivée</p>
            <p><strong>Date de Départ :</strong> Date de Départ</p>
            <p><strong>Heure de Départ :</strong> Heure de Départ</p>
            <p><strong>Montant :</strong> Montant €</p>
        </div>

        <p>Un email de confirmation vous a été envoyé à l'adresse Email de l'utilisateur.</p>
        <p>Merci d'avoir utilisé notre service de gestion de parking !</p>

        <a href="dashboard.php">Retourner au Tableau de Bord</a>
    </div>
</main>
</body>
</html>