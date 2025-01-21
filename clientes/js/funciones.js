function confirmarEliminar() {
    // Muestra la ventana de confirmación
    const confirmacion = window.confirm("¿Estás seguro de que deseas eliminar?");

    if (confirmacion) {
        // Si el usuario confirma, se envía el formulario
        // El formulario se envía automáticamente al servidor
        event.target.closest("form").submit();
    } else {
        // Si el usuario cancela, no se hace nada
        return false;
    }
}