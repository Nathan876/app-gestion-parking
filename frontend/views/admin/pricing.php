<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tarifs - Admin</title>
    <link rel="stylesheet" href="../styles.css">

</head>
<body>
<?php include 'navbar.php'; ?>
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

            <label for="priority">Priorité :</label>
            <select id="priority" name="priority" required>
                <option value="0">Faible</option>
                <option value="5">Importante</option>
                <option value="10">Très importante</option>
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
<div id="editModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span onclick="closeEditModal()" style="float:right; cursor:pointer;">&times;</span>
        <h3>Modifier un tarif</h3>
        <form id="editPricingForm">
            <input type="hidden" id="edit_id" />

            <label>Tarif (€):</label>
            <input type="number" step="0.01" id="edit_price_per_hour" required />

            <label>Début:</label>
            <input type="date" id="edit_start_date" required />
            <input type="time" id="edit_start_time" required />

            <label>Fin:</label>
            <input type="date" id="edit_end_date" required />
            <input type="time" id="edit_end_time" required />

            <label>Jour:</label>
            <select id="edit_week_day" required>
                <option value="Monday">Lundi</option>
                <option value="Tuesday">Mardi</option>
                <option value="Wednesday">Mercredi</option>
                <option value="Thursday">Jeudi</option>
                <option value="Friday">Vendredi</option>
                <option value="Saturday">Samedi</option>
                <option value="Sunday">Dimanche</option>
            </select>

            <label>Priorité :</label>
            <select id="edit_priority" required>
                <option value="0">Faible</option>
                <option value="5">Importante</option>
                <option value="10">Très importante</option>
            </select>

            <button type="submit">Enregistrer</button>
        </form>
    </div>
</div>
</body>
<script type="module">
import {requireAuth} from "../../public/auth.js";
requireAuth(0);
</script>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        await loadPricing();
    });

    async function loadPricing() {
        const tbody = document.getElementById('pricingTableBody');
        tbody.innerHTML = '';

        const res = await fetch('https://api.trouvetaplace.local/pricing', {
            credentials: 'include'
        });
        const prices = await res.json();

        prices.forEach(price => {
            const row = document.createElement('tr');
            row.innerHTML = `
      <td>${price.id}</td>
      <td>${price.parking_id}</td>
      <td>${typeToText(price.space_type)}</td>
      <td>${price.start_date}</td>
      <td>${price.end_date}</td>
      <td>${price.start_time}</td>
      <td>${price.end_time}</td>
      <td>${price.week_day}</td>
      <td>${price.price_per_hour} €</td>
      <td>
        <button onclick="openEditModal(${encodeURIComponent(JSON.stringify(price))})">Modifier</button>
        <button onclick="deletePricing(${price.id})">Supprimer</button>
      </td>
    `;
            tbody.appendChild(row);
        });
    }

    function typeToText(type) {
        return ['Standard', 'Handicapé', 'Moto', 'Vélo'][type] ?? 'Inconnu';
    }

    function openEditModal(rawData) {
        const price = JSON.parse(decodeURIComponent(rawData));
        document.getElementById('edit_id').value = price.id;
        document.getElementById('edit_price_per_hour').value = price.price_per_hour;
        document.getElementById('edit_start_date').value = price.start_date;
        document.getElementById('edit_end_date').value = price.end_date;
        document.getElementById('edit_start_time').value = price.start_time;
        document.getElementById('edit_end_time').value = price.end_time;
        document.getElementById('edit_week_day').value = price.week_day;
        document.getElementById('edit_priority').value = price.priority;

        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    document.getElementById('editPricingForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = {
            id: parseInt(document.getElementById('edit_id').value),
            price_per_hour: parseFloat(document.getElementById('edit_price_per_hour').value),
            start_date: document.getElementById('edit_start_date').value,
            end_date: document.getElementById('edit_end_date').value,
            start_time: document.getElementById('edit_start_time').value,
            end_time: document.getElementById('edit_end_time').value,
            week_day: document.getElementById('edit_week_day').value,
            priority: parseInt(document.getElementById('edit_priority').value)
        };

        const res = await fetch('https://api.trouvetaplace.local/pricing', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify(data)
        });

        const result = await res.json();
        if (result.success) {
            alert('Modifié avec succès !');
            closeEditModal();
            loadPricing();
        } else {
            alert('Erreur : ' + result.error);
        }
    });

    async function deletePricing(id) {
        if (!confirm('Supprimer ce tarif ?')) return;

        const res = await fetch('https://api.trouvetaplace.local/pricing', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify({ id })
        });

        const result = await res.json();
        if (result.success) {
            alert('Supprimé avec succès');
            loadPricing();
        } else {
            alert('Erreur : ' + result.error);
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', async () => {const parkingSelect = document.getElementById('parking_id');

        try {
            const response = await fetch('https://api.trouvetaplace.local/parkings', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const parkings = await response.json();

            parkingSelect.innerHTML = '<option value="">Sélectionnez un parking</option>';

            parkings.forEach(parking => {
                const option = document.createElement('option');
                option.value = parking.id;
                option.textContent = parking.name;
                parkingSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Erreur lors de la récupération des parkings:', error);
            parkingSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        }
    });
    async function addPricing() {
        const data = {
            parking_id: document.getElementById('parking_id').value,
            space_type: document.getElementById('space_type').value,
            start_date: document.getElementById('start_date').value,
            end_date: document.getElementById('end_date').value,
            start_time: document.getElementById('start_time').value,
            end_time: document.getElementById('end_time').value,
            week_day: document.getElementById('week_day').value,
            price_per_hour: parseFloat(document.getElementById('price_per_hour').value),
            priority: parseInt(document.getElementById('priority').value)
        };

        const response = await fetch('https://api.trouvetaplace.local/pricing', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify(data)
        });

        const result = await response.json();
        if (result.success) {
            alert("Tarif ajouté avec succès !");
            location.reload();
        } else {
            alert("Erreur : " + result.error);
        }
    }
</script>
</html>
