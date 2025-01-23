//Función para informar de registro exitoso
// Detecta si existe el parámetro "registro=exito" en la URL
window.onload = function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('registro') === 'exito') {
        alert('Registrado correctamente.');
        //Elimina el parámetro de la URL después de mostrar el alert
        window.history.replaceState({}, document.title, window.location.pathname);
    }
};