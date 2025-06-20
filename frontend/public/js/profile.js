export const profile = async (firstName, lastName, email, password, passwordConfirmation, birthDate, phoneNumber, licensePlate) => {
    try {
        const response = await fetch('https://api.trouvetaplace.local/profile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'include',
            body: JSON.stringify({ firstName, lastName, email, password, passwordConfirmation, birthDate, phoneNumber, licensePlate })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error || 'Erreur de connexion');
        }

        if (data.user?.role === 0) {
            window.location.href = '/views/admin/dashboard.php';
        } else if (data.user?.role === 1) {
            window.location.href = '/views/user/dashboard.php';
        }

        return data;
    } catch (error) {
        throw error;
    }
};