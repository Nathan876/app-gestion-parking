<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord utilisateur - Gestion de Parking</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
<main>
  <div>
    <h2>Bienvenue, Nom de l'utilisateur</h2>

    <div>
      <h3>Vos Réservations</h3>
      <div id="upcoming_reservations">
        <h4>Réservations à venir</h4>
        <ul>
          <li>
            <strong>Place :</strong> A12
            <strong>Date :</strong> 10 octobre 2025
            <strong>Heure :</strong> 14:00 - 16:00
            <button onclick="cancelReservation('ID')">Annuler</button>
          </li>
        </ul>
      </div>
      <div id="past_reservations">
        <h4>Réservations passées</h4>
        <ul>
          <li>
            <strong>Place :</strong> B05
            <strong>Date :</strong> 5 octobre 2025
            <strong>Heure :</strong> 09:00 - 11:00
          </li>
        </ul>
      </div>
    </div>

    <div>
      <h3>Vos Informations</h3>
      <form action="" method="post">
        <label for="first_name">Prénom :</label>
        <input type="text" id="first_name" name="first_name" value="[Prénom]" required>

        <label for="last_name">Nom :</label>
        <input type="text" id="last_name" name="last_name" value="[Nom]" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="[Email]" required>

        <label for="phone_number">Numéro de téléphone :</label>
        <input type="tel" id="phone_number" name="phone_number" value="[Téléphone]">

        <label for="license_plate">Plaque d'immatriculation :</label>
        <input type="text" id="license_plate" name="license_plate" value="[Plaque]">

        <button type="submit">Mettre à jour</button>
      </form>
    </div>
  </div>
</main>
</body>
</html>
