<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilosGenerales.css">
    <link rel="stylesheet" href="nuevoProveedorCliente.css">
    <title>Formulario de cliente</title>
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
            <h1>Añadir nuevo cliente</h1>
        </div>
        <form>
            <!-- Nombre del cliente -->
            <label for="nombre">Nombre del cliente:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre del cliente" required>

            <!-- Apellidos -->
            <label for="Apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" placeholder="Ingrese los apellidos" required>

            <!-- Teléfono -->
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" placeholder="Ingrese el teléfono del cliente" required>

            <!-- Correo electrónico -->
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" placeholder="Ingrese el correo electrónico" required>

            <!-- Dirección -->
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" placeholder="Ingrese la dirección del cliente" rows="4" required>
            
            <!-- Marca -->
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" placeholder="Ingrese la marca de la motocicleta" required>

            <!-- Marca -->
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" placeholder="Ingrese el modelo de la motocicleta" required>

            <!-- Matrícula -->
            <label for="matricula">Matrícula:</label>
            <input type="text" id="matricula" name="matricula" placeholder="Ingrese la matrícula de la motocicleta" required>

            <!-- Nº bastidor -->
            <label for="bastidor">Nº Batidor:</label>
            <input type="text" id="bastidor" name="bastidor" placeholder="Ingrese el número de bastidor de la motocicleta" required>

            <!-- F.entrada -->
            <label for="entrada">Fecha de entrada</label>
            <input type="text" id="entrada" name="entrada" placeholder="Ingrese la fecha de entrada de la motocicleta" required>

            <!-- F.salida -->
            <label for="salida">Fecha de salida</label>
            <input type="text" id="salida" name="salida" placeholder="Ingrese la fecha de salida de la motocicleta" required>

            <!-- Notas adicionales -->
            <label for="notas">Notas adicionales:</label>
            <textarea id="notas" name="notas" placeholder="Ingrese cualquier comentario adicional" rows="4"></textarea>

            <!-- Botón para enviar -->
            <button type="submit">Guardar cliente</button>
            
            <!--Botón para vovler-->
            <div id="botones">
                <a href = "indexAdmin.php">Volver</a>
            </div>
        </form>
        
    </div>
</body>
</html>