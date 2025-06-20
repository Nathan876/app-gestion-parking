export async function requireAuth(requiredRole = null) {
    await fetch('https://api.trouvetaplace.local/auth', {
        method: 'GET',
        credentials: 'include'
    })
        .then(res => {
            if (!res.ok) {
                throw new Error('Non authentifié');
                return;
            }
            return res.json();
        })
        .then(data => {
            if (!data.authenticated) {
                throw new Error('Utilisateur non connecté');
                return;
            }

            if (requiredRole !== null && data.role !== requiredRole) {
                throw new Error('Accès non autorisé');
                return;
            }

            console.log("Utilisateur connecté :", data);
            return data;
        })
        .catch(err => {
            console.warn("Accès refusé :", err.message);
            window.location.href = 'https://trouvetaplace.local/views/login.php';
        });

}