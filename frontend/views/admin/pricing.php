<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tarifs - Admin</title>
    <link rel="stylesheet" href="../styles.css">

</head>
<body>
<main>
    <div>
        <h2>Gestion des Tarifs</h2>

        <h3>Ajouter un Tarif</h3>
        <form id="addPricingForm">
            <label for="parking_id">Parking :</label>
            <select id="parking_id" name="parking_id" required>
                <option value="">Sélectionnez un parking</option>
                <option value="1">Parking Centre-Ville</option>
                <option value="2">Parking Gare</option>
            </select>

            <label for="space_type">Type de Place :</label>
            <select id="space_type" name="space_type" required>
                <option value="">Sélectionnez un type</option>
                <option value="0">Standard</option>
                <option value="1">Handicapé</option>
                <option value="2">Moto</option>
                <option value="3">Vélo</option>
            </select>

            <label for="start_date">Date de Début :</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">Date de Fin :</label>
            <input type="date" id="end_date" name="end_date" required>

            <label for="start_time">Heure de Début :</label>
            <input type="time" id="start_time" name="start_time" required>

            <label for="end_time">Heure de Fin :</label>
            <input type="time" id="end_time" name="end_time" required>

            <label for="week_day">Jour de la Semaine :</label>
            <select id="week_day" name="week_day" required>
                <option value="">Sélectionnez un jour</option>
                <option value="monday">Lundi</option>
                <option value="tuesday">Mardi</option>
                <option value="wednesday">Mercredi</option>
                <option value="thursday">Jeudi</option>
                <option value="friday">Vendredi</option>
                <option value="saturday">Samedi</option>
                <option value="sunday">Dimanche</option>
                <option value="weekend">Week-end</option>
            </select>

            <label for="price_per_hour">Tarif par Heure (€) :</label>
            <input type="number" step="0.01" id="price_per_hour" name="price_per_hour" required>

            <button type="button" onclick="addPricing()">Ajouter</button>
        </form>

        <h3>Liste des Tarifs</h3>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Parking</th>
                <th>Type de Place</th>
                <th>Date de Début</th>
                <th>Date de Fin</th>
                <th>Heure de Début</th>
                <th>Heure de Fin</th>
                <th>Jour de la Semaine</th>
                <th>Tarif par Heure</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="pricingTableBody">
            <tr>
                <td>1</td>
                <td>Parking Centre-Ville</td>
                <td>Standard</td>
                <td>2025-01-01</td>
                <td>2025-12-31</td>
                <td>08:00</td>
                <td>18:00</td>
                <td>Lundi</td>
                <td>2.50 €</td>
                <td class="action-buttons">
                    <button onclick="editPricing(1)">Modifier</button>
                    <button onclick="deletePricing(1)">Supprimer</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
