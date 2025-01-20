<?php
    require("../comprobarAdmin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="nuevoProveedor.css">
    <title>Formulario de Proveedor</title>
</head>
<body>
    <div class="sidebar">
        <a href="indexAdmin.php#clientes">Clientes</a>
        <a href="indexAdmin.php#proveedores">Proveedores</a>
        <a href="indexAdmin.php#citas">Citas</a>
        <a href="indexAdmin.php#stock">Stock</a>  
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Añadir nuevo proveedor</h1>
        </div>
        <form method="POST">
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
<?php
require '../vendor/autoload.php'; // Cargar librería de MongoDB
use MongoDB\Driver\Exception\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos del formulario
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $notas = $_POST['notas'];

    try {
        // Conectar a MongoDB
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $collection = $client->gestor->proovedores; // Base de datos 'gestor', colección 'proovedores'

        // Insertar datos en la base de datos
        $result = $collection->insertOne([
            'nombre' => $nombre,
            'contacto' => $contacto,
            'telefono' => $telefono,
            'email' => $email,
            'direccion' => $direccion,
            'notas' => $notas,
            'timestamp' => new MongoDB\BSON\UTCDateTime(new DateTime()) // Agregar timestamp de fecha de creación
        ]);

        echo "Proveedor registrado con ID: " . $result->getInsertedId();
    } catch (Exception $e) {
        echo "Error al registrar el proveedor: " . $e->getMessage();
    }
}
?>