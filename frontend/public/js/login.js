export const login = async (email, password) => {
    try {
        const response = await fetch('https://api.trouvetaplace.local/authentification', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'include',
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error || 'Erreur de connexion');
        }

        const permission = await Notification.requestPermission();
        if (permission !== 'granted') {
            console.warn('Notifications refusées par l’utilisateur.');
        } else {
            if ('serviceWorker' in navigator) {
                await navigator.serviceWorker.register('/service-worker.js');

                const beamsClient = new PusherPushNotifications.Client({
                    instanceId: '8b16b2b6-56f2-4951-a346-421c0a38f58d'
                });

                const userId = 'user_' + data.user.id;

                try {
                    await beamsClient.start();
                    await beamsClient.addDeviceInterest(userId);
                    console.log('Notifications configurées pour :', userId);
                } catch (notifErr) {
                    console.error('Erreur de configuration des notifications :', notifErr);
                }
            }
        }

        return data;
    } catch (error) {
        console.error('Erreur dans login.js :', error);
        throw error;
    }
};