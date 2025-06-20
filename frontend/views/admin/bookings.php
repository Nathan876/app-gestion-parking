<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Réservations - Admin</title>
  <link rel="stylesheet" href="../styles.css">

</head>
<div class="errors"></div>
<div id="editModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-button" onclick="closeEditModal()">&times;</span>
        <h3>Modifier la réservation</h3>
        <form id="editBookingForm">
            <input type="hidden" id="edit_id" />

            <label>Date d'arrivée :</label>
            <input type="date" id="edit_arrival_date" required />

            <label>Heure d'arrivée :</label>
            <input type="time" id="edit_arrival_time" required />

            <label>Date de départ :</label>
            <input type="date" id="edit_departure_date" required />

            <label>Heure de départ :</label>
            <input type="time" id="edit_departure_time" required />

            <label>Statut :</label>
            <select id="edit_status" required>
                <option value="pending">En attente</option>
                <option value="confirmed">Confirmée</option>
                <option value="cancelled">Annulée</option>
                <option value="completed">Complétée</option>
            </select>

            <button type="submit">Enregistrer</button>
        </form>
    </div>
</div>
<body>
<?php include 'navbar.php'; ?>
<main>
  <div>
    <h2>Gestion des Réservations</h2>

<!--    <div class="filter-section">-->
<!--      <h3>Filtrer les Réservations</h3>-->
<!--      <label for="filterDate">Date :</label>-->
<!--      <input type="date" id="filterDate" name="filterDate">-->
<!---->
<!--      <label for="filterUser">Utilisateur :</label>-->
<!--      <select id="filterUser" name="filterUser">-->
<!--        <option value="">Tous les utilisateurs</option>-->
<!--        <option value="1">Jean Dupont</option>-->
<!--        <option value="2">Marie Martin</option>-->
<!--      </select>-->
<!---->
<!--      <label for="filterStatus">Statut :</label>-->
<!--      <select id="filterStatus" name="filterStatus">-->
<!--        <option value="">Tous les statuts</option>-->
<!--        <option value="pending">En attente</option>-->
<!--        <option value="confirmed">Confirmée</option>-->
<!--        <option value="cancelled">Annulée</option>-->
<!--        <option value="completed">Complétée</option>-->
<!--      </select>-->
<!---->
<!--      <button onclick="filterBookings()">Filtrer</button>-->
<!--    </div>-->

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
          <th>Actions</th>
      </tr>
      </thead>
      <tbody id="bookingsTableBody"></tbody>
    </table>
  </div>
</main>

</body>
<script type="module">
    import { requireAuth } from '../../public/auth.js';
    requireAuth(0);
</script>
<script>
    const tbody = document.getElementById('bookingsTableBody');
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editBookingForm');

    let bookings = [];

    document.addEventListener('DOMContentLoaded', async () => {
        const res = await fetch('https://api.trouvetaplace.local/bookings', {
            method: 'GET',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
        });
        bookings = await res.json();
        renderTable(bookings);
    });

    function renderTable(data) {
        tbody.innerHTML = '';
        data.forEach(booking => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${booking.id}</td>
                <td>${booking.first_name} ${booking.last_name}</td>
                <td>${booking.parking_name}</td>
                <td>${booking.space_number}</td>
                <td>${booking.arrival_date}</td>
                <td>${booking.arrival_time}</td>
                <td>${booking.departure_date}</td>
                <td>${booking.departure_time}</td>
                <td>${formatStatus(booking.status)}</td>
                <td>${booking.amount} €</td>
                <td>
                    <button onclick="openEditModal(${booking.id})">Modifier</button>
                    <button onclick="deletePlace(${booking.id})">Supprimer</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function openEditModal(id) {
        const booking = bookings.find(b => b.id === id);
        if (!booking) {
            document.querySelector("errors").innerHTML("Réservation introuvable");
        }

        document.getElementById('edit_id').value = booking.id;
        document.getElementById('edit_arrival_date').value = booking.arrival_date;
        document.getElementById('edit_arrival_time').value = booking.arrival_time;
        document.getElementById('edit_departure_date').value = booking.departure_date;
        document.getElementById('edit_departure_time').value = booking.departure_time;
        document.getElementById('edit_status').value = booking.status;

        modal.style.display = 'flex';
        document.body.classList.add('modal-open');
        document.body.style.position = 'fixed';
        document.body.style.width = '100%';
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('edit_id').value;

        const updatedData = {
            id: id,
            arrival_date: document.getElementById('edit_arrival_date').value,
            arrival_time: document.getElementById('edit_arrival_time').value,
            departure_date: document.getElementById('edit_departure_date').value,
            departure_time: document.getElementById('edit_departure_time').value,
            status: document.getElementById('edit_status').value
        };

        const response = await fetch(`https://api.trouvetaplace.local/reservation`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify(updatedData)
        });

        const result = await response.json();

        if (response.ok && result.success) {
            closeEditModal();
            updateRow(result.reservation);
        } else {
            document.querySelector("errors").innerHTML(result.error || 'Erreur lors de la mise à jour');
        }
    });

    function updateRow(updated) {
        const row = [...tbody.rows].find(row => row.cells[0].textContent === updated.id.toString());
        if (!row) return;
        row.cells[4].textContent = updated.arrival_date;
        row.cells[5].textContent = updated.arrival_time;
        row.cells[6].textContent = updated.departure_date;
        row.cells[7].textContent = updated.departure_time;
        row.cells[8].textContent = updated.status;
    }

    function closeEditModal() {
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
        document.body.style.position = '';
        document.body.style.width = '';
    }

    function deletePlace(id) {
        if (!confirm("Confirmer la suppression ?")) return;
        fetch(`https://api.trouvetaplace.local/reservation`, {
            method: 'DELETE',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ id: id })
        })
            .then(res => {
                document.querySelector("errors").innerHTML("Erreur lors de la suppression")
            })
            .then(() => {
                bookings = bookings.filter(b => b.id !== id);
                renderTable(bookings);
            })
            .catch(err => document.querySelector("errors").innerHTML(err.message));
    }

    function formatStatus(status) {
        const statusMapping = {
            'pending': 'En attente',
            'confirmed': 'Confirmée',
            'cancelled': 'Annulée',
            'completed': 'Terminée'
        };
        return statusMapping[status.toLowerCase()] || status;
    }
</script>
</html>
