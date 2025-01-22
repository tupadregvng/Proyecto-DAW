<?php
    require("../comprobarAdmin.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="css/nuevoProveedor.css">
    <title>Formulario de Vehículo</title>
</head>
<body>
    <div class="sidebar">
        <a href="indexAdmin.php#usuarios">Usuarios</a>
        <a href="indexAdmin.php#clientes">Clientes</a>
        <a href="indexAdmin.php#proveedores">Proveedores</a>
        <a href="indexAdmin.php#citas">Citas</a>
        <a href="indexAdmin.php#vehiculos">Vehículos</a>

        <div class="cerrar">
            <a href="../index.php">Cerrar sessión</a>
        </div>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Añadir nuevo vehículo</h1>
        </div>
        <form method="POST">
            <!-- Seleccionar cliente -->
            <label for="clienteSeleccionado">Seleccionar Cliente:</label>
            <select id="clienteSeleccionado" name="cliente" required>
                <?php
                require '../vendor/autoload.php'; // Cargar librería de MongoDB
                $client = new MongoDB\Client("mongodb://localhost:27017");
                $usuariosCollection = $client->gestor->usuarios; // Base de datos 'gestor', colección 'usuarios'
                
                $usuarios = $usuariosCollection->find();
                foreach ($usuarios as $usuario) {
                    echo "<option value='" . htmlspecialchars($usuario['email']) . "'>" . htmlspecialchars($usuario['email']) . "</option>";
                }
                ?>
            </select>

            <!-- Marca -->
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" placeholder="Ingrese la marca del vehículo" required>

            <!-- Modelo -->
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" placeholder="Ingrese el modelo del vehículo" required>

            <!-- Bastidor -->
            <label for="bastidor">Número de Bastidor:</label>
            <input type="text" id="bastidor" name="bastidor" pattern="^[A-Za-z0-9]{17}$"  placeholder = " Ingrese el número de bastidor (17 dígitos)" required>

            <!-- Matrícula -->
            <label for="matricula">Matrícula:</label>
            <input type="text" id="matricula" name="matricula" pattern="(^\d{4}\s?[A-Z]{3}$)"  placeholder = "Ingrese la matrícula (ej:1234 ZZZ)" required>

            <!-- Notas adicionales -->
            <label for="notas">Notas adicionales:</label>
            <textarea id="notas" name="notas" placeholder="Ingrese cualquier comentario adicional" rows="4"></textarea>

            <!-- Botón para enviar -->
            <button type="submit">Guardar vehículo</button>
            
            <!-- Botón para volver -->
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
    $cliente = $_POST['cliente'];  // Cliente seleccionado del formulario
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $bastidor = $_POST['bastidor'];
    $matricula = $_POST['matricula'];
    $notas = $_POST['notas'];

    try {
        // Conectar a MongoDB
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $collection = $client->gestor->motos; // Base de datos 'gestor', colección 'motos'

        // Insertar datos en la base de datos
        $result = $collection->insertOne([
            'cliente' => $cliente, // Guardar el nombre del cliente
            'marca' => $marca,
            'modelo' => $modelo,
            'bastidor' => $bastidor,
            'matricula' => $matricula,
            'notas' => $notas,
            'estado' => "En circulación",
            'timestamp' => new MongoDB\BSON\UTCDateTime(new DateTime()) // Agregar timestamp de fecha de creación
        ]);

        # echo "Vehículo registrado con ID: " . $result->getInsertedId();
    } catch (Exception $e) {
        # echo "Error al registrar el vehículo: " . $e->getMessage();
    }
}
?>
