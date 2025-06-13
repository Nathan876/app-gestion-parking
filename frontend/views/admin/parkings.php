<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Places de Parking - Admin</title>
    <link rel="stylesheet" href="../styles.css">

</head>
<body>
<?php include 'navbar.php'; ?>
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

            <button type="button" onclick="addParking()">Ajouter</button>
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
<script>
    async function addParking() {
        const formData = new FormData(document.getElementById('addParkingForm'));

        const response = await fetch('http://127.0.0.1:81/app-gestion-parking/backend/index.php/parking', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        console.log(result);
    }

    document.addEventListener('DOMContentLoaded', () => {
        fetch('http://127.0.0.1:81/app-gestion-parking/backend/index.php/parking')
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('parkingTableBody');
                tbody.innerHTML = '';
                data.forEach(place => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
          <td>${place.id}</td>
          <td>${place.parking_name}</td>
          <td>${place.space_number}</td>
          <td>${typeToText(place.space_type)}</td>
          <td>${place.status ?? 'Libre'}</td>
          <td class="action-buttons">
            <button onclick="deletePlace(${place.id})">Supprimer</button>
          </td>
        `;
                    tbody.appendChild(tr);
                });
            });
    });

    document.getElementById('addParkingForm').addEventListener('submit', e => {
        e.preventDefault();
        const formData = new FormData(e.target);

        fetch('/add', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(() => location.reload());
    });

    async function deletePlace(id) {
        if (!id) {
            console.error('ID manquant pour la suppression.');
            return;
        }

        const formData = new FormData();
        formData.append('id', id);

        try {
            const response = await fetch('http://127.0.0.1:81/app-gestion-parking/backend/index.php/parking/delete', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Erreur lors de la suppression');
            }

            const data = await response.json();
            console.log('Place supprimée:', data);
            location.reload();
        } catch (error) {
            console.error('Erreur :', error);
            alert('La suppression a échoué.');
        }
    }

    function typeToText(type) {
        return ['Standard', 'Handicapé', 'Moto', 'Vélo'][type] ?? 'Inconnu';
    }
</script>
</html>
