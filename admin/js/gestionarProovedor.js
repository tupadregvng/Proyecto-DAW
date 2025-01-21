function openModal(row) {
    const modal = document.getElementById('editModal');
    const overlay = document.getElementById('modalOverlay');
    
    // Fill form fields with row data
    document.getElementById('editId').value = row.dataset.id;
    document.getElementById('editNombre').value = row.querySelector('.nombre').innerText;
    document.getElementById('editContacto').value = row.querySelector('.contacto').innerText;
    document.getElementById('editTelefono').value = row.querySelector('.telefono').innerText;
    document.getElementById('editEmail').value = row.querySelector('.email').innerText;
    document.getElementById('editDireccion').value = row.querySelector('.direccion').innerText;
    document.getElementById('editNotas').value = row.querySelector('.notas').innerText;

    modal.classList.add('active');
    overlay.classList.add('active');
}

function closeModal() {
    document.getElementById('editModal').classList.remove('active');
    document.getElementById('modalOverlay').classList.remove('active');
}