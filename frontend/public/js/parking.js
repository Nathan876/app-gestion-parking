export async function addParking() {
    const formData = new FormData(document.getElementById('addParkingForm'));
    const response = await fetch('https://api.trouvetaplace.local/parking', {
        method: 'POST',
        body: formData
    });

    const result = await response.json();
    console.log(result);
    location.reload();
}

export function typeToText(type) {
    return ['Standard', 'Handicapé', 'Moto', 'Vélo'][type] ?? 'Inconnu';
}

export async function deletePlace(id) {
    if (!confirm("Confirmer la suppression ?")) return;

    try {
        const response = await fetch('https://api.trouvetaplace.local/parking', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });

        if (!response.ok) throw new Error('Erreur lors de la suppression');
        await response.json();
        location.reload();
    } catch (error) {
        console.error('Erreur :', error);
        alert('La suppression a échoué.');
    }
}

export function editPlace(id) {
    const modal = document.getElementById('editModal');
    const editParkingId = document.getElementById('edit_parking_id');
    const place = allSpaces.find(p => p.id === id);
    if (!place) {
        return alert("Place introuvable");
    }

    editParkingId.innerHTML = '<option value="">Sélectionnez un parking</option>';
    allParkings.forEach(parking => {
        const option = document.createElement('option');
        option.value = parking.id;
        option.textContent = parking.name;
        if (parking.id === place.parking_id) option.selected = true;
        editParkingId.appendChild(option);
    });

    document.getElementById('edit_id').value = place.id;
    document.getElementById('edit_space_number').value = place.space_number;
    document.getElementById('edit_space_type').value = place.space_type;

    modal.style.display = 'flex';
    document.body.classList.add('modal-open');
    document.body.style.position = 'fixed';
    document.body.style.width = '100%';
}