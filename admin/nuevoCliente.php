<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
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
        <form method="POST">
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
<?php
require '../vendor/autoload.php'; // Cargar librería de MongoDB
use MongoDB\Driver\Exception\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos del formulario
    $name = $_POST['name'];
    $apellidos= $_POST['apellidos'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 0; // Asignar rol de usuario (1 para admin)
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    try {
        // Conectar a MongoDB
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $collection = $client->registro->usuarios; // Base de datos, carpeta 'registro', colección 'usuarios'

        // Insertar datos en la base de datos
        $result = $collection->insertOne([
            'email' => $email,
            'password' => $password, // Contraseña sin encriptar por ahora
            'role' => $role, // Rol de usuario
            'name' => $name,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'direccion' => $direccion
        ]);

        echo "Usuario registrado con ID: " . $result->getInsertedId();
    } catch (Exception $e) {
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
}
?>