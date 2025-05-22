<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Réservations - Admin</title>
  <link rel="stylesheet" href="../styles.css">

</head>
<body>
<main>
  <div>
    <h2>Gestion des Réservations</h2>

    <div class="filter-section">
      <h3>Filtrer les Réservations</h3>
      <label for="filterDate">Date :</label>
      <input type="date" id="filterDate" name="filterDate">

      <label for="filterUser">Utilisateur :</label>
      <select id="filterUser" name="filterUser">
        <option value="">Tous les utilisateurs</option>
        <option value="1">Jean Dupont</option>
        <option value="2">Marie Martin</option>
      </select>

      <label for="filterStatus">Statut :</label>
      <select id="filterStatus" name="filterStatus">
        <option value="">Tous les statuts</option>
        <option value="pending">En attente</option>
        <option value="confirmed">Confirmée</option>
        <option value="cancelled">Annulée</option>
        <option value="completed">Complétée</option>
      </select>

      <button onclick="filterBookings()">Filtrer</button>
    </div>

    <table>
      <thead>
      <tr>
        <th>ID</th>
        <th>Utilisateur</th>
        <th>Parking</th>
        <th>Numéro de Place</th>
        <th>Date d'Arrivée</th>
        <th>Heure d'Arrivée</th>
        <th>Date de Départ</th>
        <th>Heure de Départ</th>
        <th>Statut</th>
        <th>Montant</th>
      </tr>
      </thead>
      <tbody id="bookingsTableBody">
      <tr>
        <td>1</td>
        <td>Jean Dupont</td>
        <td>Parking Centre-Ville</td>
        <td>A1</td>
        <td>2025-10-10</td>
        <td>14:00</td>
        <td>2025-10-10</td>
        <td>16:00</td>
        <td>Confirmée</td>
        <td>5.00 €</td>
      </tr>
      </tbody>
    </table>
  </div>
</main>

</body>
</html>
