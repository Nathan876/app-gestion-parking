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
        <h2>Gestion des Parkings</h2>

        <h3>Ajouter une Place de Parking</h3>
        <form id="addParkingForm">
            <label for="parking_name">Nom du parking :</label>
            <input type="text" id="parking_name" name="name" required>

            <label for="address">Adresse :</label>
            <input type="text" id="address" name="address" required>

            <label for="city">Ville :</label>
            <input type="text" id="city" name="city" required>

            <label for="postal_code">Code postal :</label>
            <input type="text" id="postal_code" name="postal_code" required>

            <button type="submit">Ajouter</button>
        </form>

        <h3>Liste des Places de Parking</h3>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Nombre de places</th>
                <th>Adresse</th>
                <th>Ville</th>
                <th>Code postal</th>
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
<div id="editModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Modifier le parking</h3>
        <form id="editParkingForm">
            <input type="hidden" id="edit_id">

            <label for="edit_name">Nom du parking :</label>
            <input type="text" id="edit_name" required>

            <label for="edit_address">Adresse :</label>
            <input type="text" id="edit_address" required>

            <label for="edit_city">Ville :</label>
            <input type="text" id="edit_city" required>

            <label for="edit_postal_code">Code postal :</label>
            <input type="text" id="edit_postal_code" required>

            <button type="submit">Enregistrer</button>
        </form>
    </div>
</div>
</body>
<script>
    async function addParking(event) {
        event.preventDefault();
        const formData = {
            id: document.getElementById('edit_id').value,
            name: document.getElementById('parking_name').value.trim(),
            address: document.getElementById('address').value.trim(),
            city: document.getElementById('city').value.trim(),
            postal_code: document.getElementById('postal_code').value.trim()
        };

        try {
            const response = await fetch('https://api.trouvetaplace.local/parkings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || 'Erreur lors de l’ajout');
            }

            alert('Parking ajouté avec succès');
            location.reload();
        } catch (error) {
            console.error('Erreur:', error);
            alert(error.message);
        }
    }

    function openEditModal(parking) {
        document.getElementById('edit_id').value = parking.id;
        document.getElementById('edit_name').value = parking.name;
        document.getElementById('edit_address').value = parking.address;
        document.getElementById('edit_city').value = parking.city;
        document.getElementById('edit_postal_code').value = parking.postal_code;

        document.getElementById('editModal').style.display = 'block';
    }

    async function updateParking(id) {
        try {
            const response = await fetch(`https://api.trouvetaplace.local/parkings`, {
                method: 'GET',
                credentials: 'include'
            });

            if (!response.ok) throw new Error('Erreur lors de la récupération');

            const parkings = await response.json();
            const parking = parkings.find(p => p.id === id);

            if (!parking) {
                alert('Parking non trouvé');
                return;
            }

            openEditModal(parking);
        } catch (error) {
            alert(error.message);
        }
    }

    document.getElementById('editParkingForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const id = document.getElementById('edit_id').value;
        const formData = {
            name: document.getElementById('edit_name').value.trim(),
            address: document.getElementById('edit_address').value.trim(),
            city: document.getElementById('edit_city').value.trim(),
            postal_code: document.getElementById('edit_postal_code').value.trim()
        };

        try {
            const response = await fetch(`https://api.trouvetaplace.local/parkings`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify({id: id, formData})
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.error || 'Erreur lors de la modification');
            }

            alert('Parking modifié avec succès');
            location.reload();
        } catch (error) {
            alert(error.message);
        }
    });

    document.querySelector('.close').addEventListener('click', () => {
        document.getElementById('editModal').style.display = 'none';
    });

    document.addEventListener('DOMContentLoaded', () => {
        fetch('https://api.trouvetaplace.local/parkings')
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('parkingTableBody');
                tbody.innerHTML = '';
                data.forEach(parking => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${parking.id}</td>
                        <td>${parking.name}</td>
                        <td>${parking.total_capacity ?? '-'}</td>
                        <td>${parking.address}</td>
                        <td>${parking.city}</td>
                        <td>${parking.postal_code}</td>
                        <td class="action-buttons">
                            <button onclick="updateParking(${parking.id})">Modifier</button>
                            <button onclick="deleteParking(${parking.id})">Supprimer</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            });
    });

    document.getElementById('addParkingForm').addEventListener('submit', addParking);
    async function deleteParking(id) {
        if (!id) {
            console.error('ID manquant pour la suppression.');
            return;
        }

        try {
            const response = await fetch(`https://api.trouvetaplace.local/parkings`, {
                method: 'DELETE',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Erreur lors de la suppression');
            }

            alert('Parking supprimé');
            location.reload();
        } catch (error) {
            console.error('Erreur :', error);
            alert('La suppression a échoué : ' + error.message);
        }
    }

    function typeToText(type) {
        return ['Standard', 'Handicapé', 'Moto', 'Vélo'][type] ?? 'Inconnu';
    }
</script>
</html>
