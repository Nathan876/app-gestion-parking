<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Utilisateurs - Admin</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<main>
  <div>
    <h2>Gestion des Utilisateurs</h2>
    <table>
      <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Statut</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody id="userTableBody">
      <tr>
        <td>1</td>
        <td>Dupont</td>
        <td>Jean</td>
        <td>jean.dupont@example.com</td>
        <td>0123456789</td>
        <td>Actif</td>
        <td class="action-buttons">
          <button>Désactiver</button>
          <button>Supprimer</button>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</main>
</body>
</html>
