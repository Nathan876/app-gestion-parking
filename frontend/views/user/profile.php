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
      <form action="" method="post">
        <label for="first_name">Prénom :</label>
        <input type="text" id="first_name" name="first_name" value="Prénom" required>

        <label for="last_name">Nom :</label>
        <input type="text" id="last_name" name="last_name" value="Nom" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="Email" required>

        <label for="phone_number">Numéro de téléphone :</label>
        <input type="tel" id="phone_number" name="phone_number" value="Téléphone">

        <label for="license_plate">Plaque d'immatriculation :</label>
        <input type="text" id="license_plate" name="license_plate" value="Plaque">

        <button type="submit">Mettre à jour</button>
      </form>
    </div>

    <div>
      <h3>Préférences de Paiement</h3>
      <form action="" method="post">
        <label for="card_number">Numéro de carte :</label>
        <input type="text" id="card_number" name="card_number" value="Numéro de carte" required>

        <label for="expiry_date">Date d'expiration :</label>
        <input type="month" id="expiry_date" name="expiry_date" value="Date d'expiration" required>

        <label for="cvv">CVV :</label>
        <input type="text" id="cvv" name="cvv" value="CVV" required>

        <button type="submit">Mettre à jour</button>
      </form>
    </div>
  </div>
</main>
</body>
</html>