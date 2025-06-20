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
                <th>Plaque d'immatriculation</th>
                <th>Statut</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="userTableBody"></tbody>
        </table>
    </div>
    <div id="editModal" class="modal" style="display: none">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Modifier l'utilisateur</h3>
            <form id="editUserForm">
                <input type="hidden" id="userId" name="id">
                <div class="form-group">
                    <label for="lastName">Nom</label>
                    <input type="text" id="lastName" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="firstName">Prénom</label>
                    <input type="text" id="firstName" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="tel" id="phone" name="phone_number">
                </div>
                <div class="form-group">
                    <label for="license_plate">Plaque d'immatriculation</label>
                    <input type="text" id="license_plate" name="license_plate">
                </div>

                <div class="form-group">
                    <label for="role">Rôle</label>
                    <select id="role" name="role" required>
                        <option value="0">Administrateur</option>
                        <option value="1">Utilisateur</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status du compte</label>
                    <select id="status" name="status" required>
                        <option value="0">Désactif</option>
                        <option value="1">Actif</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</main>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('editModal');
        const closeBtn = document.querySelector('.close');
        const editForm = document.getElementById('editUserForm');

        function updateUsersList() {
            fetch('https://api.trouvetaplace.local/users', {
                credentials: 'include'
            })
                .then(response => response.json())
                .then(users => {
                    const tbody = document.getElementById('userTableBody');
                    tbody.innerHTML = '';

                    users.forEach(user => {
                        const roleText = user.role == 1 ? 'Utilisateur' : 'Administrateur';
                        const statusText = user.status == 1 ? 'Activé' : 'Désactivé';

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.last_name}</td>
                        <td>${user.first_name}</td>
                        <td>${user.email}</td>
                        <td>${user.phone_number || ''}</td>
                        <td>${user.license_plate || ''}</td>
                        <td>${user.status ? "Désactivé" : "Activé"}</td>
                        <td>${roleText}</td>
                        <td class="action-buttons">
                            <button class="edit-btn" data-user='${JSON.stringify(user)}'>Modifier</button>
                            <button class="delete-btn" data-user-id="${user.id}">Supprimer</button>
                        </td>
                    `;
                        tbody.appendChild(tr);
                    });

                    document.querySelectorAll('.edit-btn').forEach(button => {
                        button.addEventListener('click', () => {
                            const user = JSON.parse(button.dataset.user);
                            document.getElementById('userId').value = user.id;
                            document.getElementById('lastName').value = user.last_name;
                            document.getElementById('firstName').value = user.first_name;
                            document.getElementById('email').value = user.email;
                            document.getElementById('phone').value = user.phone_number || '';
                            document.getElementById('license_plate').value = user.license_plate || '';
                            document.getElementById('role').value = parseInt(user.role);
                            document.getElementById('status').value = user.status ? '0' : '1';

                            modal.style.display = 'flex';
                            document.body.classList.add('modal-open');
                            document.body.style.position = 'fixed';
                            document.body.style.width = '100%';
                        });
                    });
                    document.querySelectorAll('.delete-btn').forEach(button => {
                        button.addEventListener('click', async () => {
                            const userId = button.dataset.userId;
                            const confirmed = confirm('Voulez-vous vraiment supprimer cet utilisateur ?');
                            if (confirmed) {
                                await deleteUser(userId);
                            }
                        });
                    });
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des utilisateurs :', error);
                });
        }

        closeBtn.onclick = () => {
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
            document.body.style.position = '';
            document.body.style.width = '';
        }
        window.onclick = (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }

        editForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(editForm);
            const userData = Object.fromEntries(formData.entries());

            try {
                const response = await fetch(`https://api.trouvetaplace.local/user`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'include',
                    body: JSON.stringify(userData)
                });

                if (response.ok) {
                    modal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                    document.body.style.position = '';
                    document.body.style.width = '';
                    updateUsersList();
                } else {
                    alert('Erreur lors de la mise à jour');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur lors de la mise à jour');
            }
        });

        updateUsersList();

    });
    async function deleteUser(userId) {
        try {
            const response = await fetch(`https://api.trouvetaplace.local/user`, {
                method: 'DELETE',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ id: userId })
            });

            if (response.ok) {
                alert('Utilisateur supprimé avec succès');
                window.location.href = "https://trouvetaplace.local/views/admin/users.php";
            } else {
                const error = await response.json();
                alert('Erreur : ' + (error.error || 'Suppression échouée'));
            }
        } catch (err) {
            console.error('Erreur lors de la suppression :', err);
        }
    }
</script>
</html>