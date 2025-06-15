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
    <div id="editModal" class="modal">
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
                <button type="submit" class="btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</main>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetch('https://api.trouvetaplace.local/users')
            .then(response => response.json())
            .then(users => {
                const tbody = document.getElementById('userTableBody');
                tbody.innerHTML = '';

                users.forEach(user => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
          <td>${user.id}</td>
          <td>${user.last_name}</td>
          <td>${user.first_name}</td>
          <td>${user.email}</td>
          <td>${user.phone_number || ''}</td>
          <td>${user.role == 1 ? 'Utilisateur' : 'Administrateur'}</td>
          <td class="action-buttons">
            <form method="post" action="https://api.trouvetaplace.local/users/delete">
              <input type="hidden" name="user_id" value="${user.id}">
              <button type="submit">Supprimer</button>
            </form>
          </td>
        `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Erreur lors du chargement des utilisateurs :', error);
            });
    });
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
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.last_name}</td>
                        <td>${user.first_name}</td>
                        <td>${user.email}</td>
                        <td>${user.phone_number || ''}</td>
                        <td>${user.role == 1 ? 'Utilisateur' : 'Administrateur'}</td>
                        <td class="action-buttons">
                            <button class="edit-btn" data-user='${JSON.stringify(user)}'>Modifier</button>
                            <form method="post" action="https://api.trouvetaplace.local/users/delete">
                                <input type="hidden" name="user_id" value="${user.id}">
                                <button type="submit">Supprimer</button>
                            </form>
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
                            modal.style.display = 'block';
                        });
                    });
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des utilisateurs :', error);
                });
        }

        closeBtn.onclick = () => modal.style.display = 'none';
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
                const response = await fetch(`https://api.trouvetaplace.local/user/${userData.id}`, {
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
</script>
</html>