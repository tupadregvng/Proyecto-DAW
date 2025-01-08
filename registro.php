<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" type="text/css" href="registro.css">
</head>
<body>
    <div class="login wrap">
        <form action="registro.php" method="POST">
            <input type="text" name="name" id="name" placeholder="Nombre" required />
            <input type="email" name="email" id="email" placeholder="Email" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" required />
            <input type="password" name="password" id="password" placeholder="Contraseña" required />
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmar Contraseña" required />
            <input type="submit" value="Registrarse" />
        </form>
        <p>Ya tienes una cuenta? <a href="index.php">Login</a></p>
    </div>
</body>
</html>
<?php
require 'vendor/autoload.php'; // Cargar librería de MongoDB
use MongoDB\Driver\Exception\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos del formulario
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 0; // Asignar rol de cliente (0)por defecto

    try {
        // Conectar a MongoDB
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $collection = $client->registro->usuarios; // Base de datos, carpeta 'registro', colección 'usuarios'

        // Insertar datos en la base de datos
        $result = $collection->insertOne([
            'email' => $email,
            'password' => $password, // Contraseña sin encriptar por ahora
            'role' => $role, // Rol de administrador
        ]);

        echo "Usuario registrado con ID: " . $result->getInsertedId();
    } catch (Exception $e) {
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
}
?>
