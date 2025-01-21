function openModal(row) {
    const modal = document.getElementById('editModal');
    const overlay = document.getElementById('modalOverlay');
    
    // Fill form fields with row data
    document.getElementById('editId').value = row.dataset.id;
    document.getElementById('editCliente').value = row.querySelector('.cliente').innerText;
    document.getElementById('editMarca').value = row.querySelector('.marca').innerText;
    document.getElementById('editModelo').value = row.querySelector('.modelo').innerText;
    document.getElementById('editBastidor').value = row.querySelector('.bastidor').innerText;
    document.getElementById('editMatricula').value = row.querySelector('.matricula').innerText;
    document.getElementById('editNotas').value = row.querySelector('.notas').innerText;
    document.getElementById('editEstado').value = row.querySelector('.estado').innerText;

    modal.classList.add('active');
    overlay.classList.add('active');
}

function closeModal() {
    document.getElementById('editModal').classList.remove('active');
    document.getElementById('modalOverlay').classList.remove('active');
}