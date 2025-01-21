<?php
    require("../comprobarAdmin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="css/nuevoProveedor.css">
    <title>Registro de Usuario</title>
</head>
<body>
    <div class="sidebar">
        <a href="indexAdmin.php#usuarios">Usuarios</a>
        <a href="indexAdmin.php#clientes">Clientes</a>
        <a href="indexAdmin.php#proveedores">Proveedores</a>
        <a href="indexAdmin.php#citas">Citas</a>
        <a href="indexAdmin.php#vehiculos">Vehículos</a>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Registrar nuevo usuario</h1>
        </div>
        <form method="POST">
            <!-- Nombre -->
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre" required>

            <!-- Correo electrónico -->
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" placeholder="Ingrese el correo electrónico" required>

            <!-- Contraseña -->
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Ingrese la contraseña" required>

            <!-- Rol (visible solo para administradores) -->
            <label for="role">Rol:</label>
            <select id="role" name="role" required>
                <option value="0">Usuario Normal</option>
                <option value="1">Administrador</option>
            </select>

            <!-- Botón para enviar -->
            <button type="submit">Registrar Usuario</button>
            
            <!--Botón para volver-->
            <div id="botones">
                <a href="indexAdmin.php">Volver</a>
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
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = (int)$_POST['role']; // Convertir a entero (0 o 1)

    try {
        // Conectar a MongoDB
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $collection = $client->gestor->usuarios; // Base de datos 'gestor', colección 'usuarios'

        // Insertar datos en la base de datos
        $result = $collection->insertOne([
            'name' => $nombre,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'timestamp' => new MongoDB\BSON\UTCDateTime(new DateTime()) // Agregar timestamp de fecha de creación
        ]);

        echo "Usuario registrado con ID: " . $result->getInsertedId();
    } catch (Exception $e) {
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
}
?>