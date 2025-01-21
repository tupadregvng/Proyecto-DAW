function openModal(row) {
    const modal = document.getElementById('editModal');
    const overlay = document.getElementById('modalOverlay');

    // Fill form fields with row data
    document.getElementById('editId').value = row.dataset.id;
    document.getElementById('editCliente').value = row.querySelector('.cliente').innerText;
    document.getElementById('editFecha').value = row.querySelector('.fecha').innerText;
    document.getElementById('editHora').value = row.querySelector('.hora').innerText;
    document.getElementById('editObservaciones').value = row.querySelector('.observaciones').innerText;

    modal.classList.add('active');
    overlay.classList.add('active');
}

function closeModal() {
    document.getElementById('editModal').classList.remove('active');
    document.getElementById('modalOverlay').classList.remove('active');
}