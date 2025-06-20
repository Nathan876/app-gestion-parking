export async function register(firstName, lastName, email, password, passwordConfirmation, birthDate, phoneNumber, licensePlate) {
    const response = await fetch('https://api.trouvetaplace.local/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include',
        body: JSON.stringify({
            first_name: firstName,
            last_name: lastName,
            email: email,
            password: password,
            password_confirmation: passwordConfirmation,
            birth_date: birthDate,
            phone_number: phoneNumber,
            license_plate: licensePlate
        })
    });

    if (!response.ok) {
        const error = await response.json();
        throw new Error(error.error || 'Erreur lors de l\'inscription');
    }

    const data = await response.json();
    return data
}