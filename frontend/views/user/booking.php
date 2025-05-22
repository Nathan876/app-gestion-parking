<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Réserver une place - Gestion de Parking</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<main>
  <div>
    <h2>Réserver une place de parking</h2>
    <form action="" method="post">
      <label for="parking_id">Choisissez le parking :</label>
      <select id="parking_id" name="parking_id" required>
        <option value="">Sélectionnez un parking</option>
        <option value="1">Parking Centre-Ville</option>
        <option value="2">Parking Gare</option>
      </select>

      <label for="space_type">Type de place :</label>
      <select id="space_type" name="space_type" required>
        <option value="">Sélectionnez un type de place</option>
        <option value="0">Standard</option>
        <option value="1">Handicapé</option>
        <option value="2">Moto</option>
        <option value="3">Vélo</option>
      </select>

      <label for="arrival_date">Date d'arrivée :</label>
      <input type="date" id="arrival_date" name="arrival_date" required>

      <label for="arrival_time">Heure d'arrivée :</label>
      <input type="time" id="arrival_time" name="arrival_time" required>

      <label for="departure_date">Date de départ :</label>
      <input type="date" id="departure_date" name="departure_date" required>

      <label for="departure_time">Heure de départ :</label>
      <input type="time" id="departure_time" name="departure_time" required>

      <button type="submit">Réserver</button>
    </form>
  </div>
</main>
</body>
</html>
