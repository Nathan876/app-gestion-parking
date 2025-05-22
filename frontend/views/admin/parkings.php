<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Places de Parking - Admin</title>
    <link rel="stylesheet" href="../styles.css">

</head>
<body>
<main>
    <div>
        <h2>Gestion des Places de Parking</h2>

        <h3>Ajouter une Place de Parking</h3>
        <form id="addParkingForm">
            <label for="parking_id">Parking :</label>
            <select id="parking_id" name="parking_id" required>
                <option value="">Sélectionnez un parking</option>
                <option value="1">Parking Centre-Ville</option>
                <option value="2">Parking Gare</option>
            </select>

            <label for="space_number">Numéro de Place :</label>
            <input type="text" id="space_number" name="space_number" required>

            <label for="space_type">Type de Place :</label>
            <select id="space_type" name="space_type" required>
                <option value="">Sélectionnez un type</option>
                <option value="0">Standard</option>
                <option value="1">Handicapé</option>
                <option value="2">Moto</option>
                <option value="3">Vélo</option>
            </select>

            <button type="button" onclick="">Ajouter</button>
        </form>

        <h3>Liste des Places de Parking</h3>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Parking</th>
                <th>Numéro de Place</th>
                <th>Type de Place</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="parkingTableBody">
            <tr>
                <td>1</td>
                <td>Parking Centre-Ville</td>
                <td>A1</td>
                <td>Standard</td>
                <td>Libre</td>
                <td class="action-buttons">
                    <button onclick="">Modifier</button>
                    <button onclick="">Supprimer</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
