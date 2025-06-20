export async function getReservation() {
    try {
        const response = await fetch(`https://api.trouvetaplace.local/lastreservation`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'include'
        });

        if (!response.ok) {
            throw new Error('Erreur lors de la récupération de la réservation');
        }

        return await response.json();
    } catch (error) {
        console.error('Erreur:', error);
        throw error;
    }
}