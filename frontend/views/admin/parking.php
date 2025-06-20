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
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Modifier la place de parking</h3>
        <form id="editParkingSpaceForm">
            <input type="hidden" id="edit_id" name="id">

            <label for="edit_parking_id">Parking :</label>
            <select id="edit_parking_id" name="parking_id" required>
                <option value="">Sélectionnez un parking</option>
            </select>

            <label for="edit_space_number">Numéro de Place :</label>
            <input type="text" id="edit_space_number" name="space_number" required>

            <label for="edit_space_type">Type de Place :</label>
            <select id="edit_space_type" name="space_type" required>
                <option value="0">Standard</option>
                <option value="1">Handicapé</option>
                <option value="2">Moto</option>
                <option value="3">Vélo</option>
            </select>

            <button type="submit">Enregistrer</button>
        </form>
    </div>
</div>
</body>
<script>
    let allSpaces = [];
    let allParkings = [];

    async function addParking() {
        const formData = new FormData(document.getElementById('addParkingForm'));
        const response = await fetch('https://api.trouvetaplace.local/parking', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        console.log(result);
        location.reload();
    }

    document.addEventListener('DOMContentLoaded', async () => {
        const parkingSelect = document.getElementById('parking_id');

        try {
            const response = await fetch('https://api.trouvetaplace.local/parkings', {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });
            allParkings = await response.json();

            parkingSelect.innerHTML = '<option value="">Sélectionnez un parking</option>';
            allParkings.forEach(parking => {
                const option = document.createElement('option');
                option.value = parking.id;
                option.textContent = parking.name;
                parkingSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Erreur lors de la récupération des parkings:', error);
            parkingSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        }

        const res = await fetch('https://api.trouvetaplace.local/parking');
        allSpaces = await res.json();

        const tbody = document.getElementById('parkingTableBody');
        tbody.innerHTML = '';
        allSpaces.forEach(place => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${place.id}</td>
                <td>${place.parking_name}</td>
                <td>${place.space_number}</td>
                <td>${typeToText(place.space_type)}</td>
                <td>${place.is_occupied ? 'Occupé' : 'Libre'}</td>
                <td class="action-buttons">
                    <button onclick="editPlace(${place.id})">Modifier</button>
                    <button onclick="deletePlace(${place.id})">Supprimer</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    });

    async function deletePlace(id) {
        if (!confirm("Confirmer la suppression ?")) return;

        try {
            const response = await fetch('https://api.trouvetaplace.local/parking', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });

            if (!response.ok) throw new Error('Erreur lors de la suppression');
            await response.json();
            alert('Place supprimée');
            location.reload();
        } catch (error) {
            console.error('Erreur :', error);
            alert('La suppression a échoué.');
        }
    }

    function editPlace(id) {
        const modal = document.getElementById('editModal');
        const editParkingId = document.getElementById('edit_parking_id');
        const place = allSpaces.find(p => p.id === id);
        if (!place) return alert("Place introuvable");

        editParkingId.innerHTML = '<option value="">Sélectionnez un parking</option>';
        allParkings.forEach(parking => {
            const option = document.createElement('option');
            option.value = parking.id;
            option.textContent = parking.name;
            if (parking.id === place.parking_id) option.selected = true;
            editParkingId.appendChild(option);
        });

        document.getElementById('edit_id').value = place.id;
        document.getElementById('edit_space_number').value = place.space_number;
        document.getElementById('edit_space_type').value = place.space_type;

        modal.style.display = 'flex';
        document.body.classList.add('modal-open');
        document.body.style.position = 'fixed';
        document.body.style.width = '100%';
    }

    document.getElementById('editParkingSpaceForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('https://api.trouvetaplace.local/parking', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include',
                body: JSON.stringify(data)
            });

            if (!response.ok) throw new Error('Erreur lors de la modification');
            await response.json();

            alert('Place modifiée avec succès');
            document.getElementById('editModal').style.display = 'none';
            location.reload();
        } catch (error) {
            console.error('Erreur:', error);
            alert('Erreur lors de la modification');
        }
    });

    document.querySelector('.close').addEventListener('click', () => {
        document.getElementById('editModal').style.display = 'none';
        document.body.classList.remove('modal-open');
        document.body.style.position = '';
        document.body.style.width = '';
    });

    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('editModal')) {
            document.getElementById('editModal').style.display = 'none';
        }
    });

    function typeToText(type) {
        return ['Standard', 'Handicapé', 'Moto', 'Vélo'][type] ?? 'Inconnu';
    }
</script>
</html>