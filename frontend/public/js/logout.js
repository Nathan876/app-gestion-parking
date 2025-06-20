export const logout = async () => {
    try {
        const response = await fetch('https://api.trouvetaplace.local/logout', {
            method: 'GET',
            credentials: 'include',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();
        if (data.redirect) {
            window.location.href = data.redirect;
        }
    } catch (error) {
        console.error('Logout error:', error);
        window.location.href = 'https://trouvetaplace.local/views/login.php';
    }
};