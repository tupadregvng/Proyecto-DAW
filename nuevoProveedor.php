<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilosGenerales.css">
    <link rel="stylesheet" href="nuevoProveedorCliente.css">
    <title>Formulario de Proveedor</title>
</head>
<body>
    <div class="sidebar">
        <a href="#clientes">Clientes</a>
        <a href="#proveedores">Proveedores</a>
        <a href="#stock">Stock</a>
        <a href="#citas">Citas</a>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Añadir nuevo proveedor</h1>
        </div>
        <form>
            <!-- Nombre del proveedor -->
            <label for="nombre">Nombre del Proveedor:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre del proveedor" required>

            <!-- Contacto -->
            <label for="contacto">Nombre de Contacto:</label>
            <input type="text" id="contacto" name="contacto" placeholder="Ingrese el nombre de contacto" required>

            <!-- Teléfono -->
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" placeholder="Ingrese el teléfono del proveedor" required>

            <!-- Correo electrónico -->
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" placeholder="Ingrese el correo electrónico" required>

            <!-- Dirección -->
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" placeholder="Ingrese la dirección del proveedor" rows="4" required>

            <!-- Notas adicionales -->
            <label for="notas">Notas adicionales:</label>
            <textarea id="notas" name="notas" placeholder="Ingrese cualquier comentario adicional" rows="4"></textarea>

            <!-- Botón para enviar -->
            <button type="submit">Guardar proveedor</button>
            
            <!--Botón para vovler-->
            <div id="botones">
                <a href = "indexAdmin.php">Volver</a>
            </div>
        </form>
        
    </div>
</body>
</html>