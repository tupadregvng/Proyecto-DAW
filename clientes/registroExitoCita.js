
// Detecta si existe el parámetro "registro=exito" en la URL
window.onload = function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('registro') === 'exito') {
        alert('Cita registrada correctamente.');
        // Opcional: Elimina el parámetro de la URL después de mostrar el alert
        window.history.replaceState({}, document.title, window.location.pathname);
    }
};