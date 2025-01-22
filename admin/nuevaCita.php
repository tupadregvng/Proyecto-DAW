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
    <title>Formulario de Citas</title>
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
            <h1>Añadir nueva cita</h1>
        </div>
        <form method="POST">
            <!-- Seleccionar cliente -->
            <label for="clienteSeleccionado">Seleccionar Usuario:</label>
            <select id="clienteSeleccionado" name="cliente" required>
                <?php
                require '../vendor/autoload.php'; // Cargar librería de MongoDB
                $client = new MongoDB\Client("mongodb://localhost:27017");
                $usuariosCollection = $client->gestor->usuarios; // Base de datos 'gestor', colección 'usuarios'
                
                $usuarios = $usuariosCollection->find();
                foreach ($usuarios as $usuario) {
                    echo "<option value='" . htmlspecialchars($usuario['name']) . "'>" . htmlspecialchars($usuario['email']) . "</option>";
                }
                ?>
            </select>

            <!-- Fecha de la cita -->
            <label for="fechaCita">Fecha de la Cita:</label>
            <input type="date" id="fechaCita" name="fecha" required>

            <!-- Hora de la cita -->
            <label for="horaCita">Hora de la Cita:</label>
            <select name="hora" id="horaCita" required>
                <option value="8:00">8:00</option>
                <option value="8:30">8:30</option>
                <option value="9:00">9:00</option>
                <option value="9:30">9:30</option>
                <option value="10:00">10:00</option>
                <option value="10:30">10:30</option>
                <option value="11:00">11:00</option>
                <option value="11:30">11:30</option>
                <option value="12:00">12:00</option>
                <option value="12:30">12:30</option>
                <option value="13:00">13:00</option>
                <option value="13:30">13:30</option>
                <option value="14:00">14:00</option>
                <option value="14:30">14:30</option>
                <option value="15:00">15:00</option>
            </select>

            <!-- Observaciones -->
            <label for="comentarios">Observaciones:</label>
            <textarea id="comentarios" name="observacion" placeholder="Ingrese cualquier comentario adicional" rows="4"></textarea>

            <!-- Botón para enviar -->
            <button type="submit">Guardar cita</button>
            
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
    $cliente = $_POST['cliente'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $observacion = $_POST['observacion'];

    try {
        // Conectar a MongoDB
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $collection = $client->gestor->citas; // Base de datos 'gestor', colección 'citas'

        // Insertar datos en la base de datos
        $result = $collection->insertOne([
            'cliente' => $cliente,
            'fecha' => $fecha,
            'hora' => $hora,
            'observaciones' => $observacion,
            'estado' => "Aceptada",
            'timestamp' => new MongoDB\BSON\UTCDateTime(new DateTime()) // Agregar timestamp de fecha de creación
        ]);

       # echo "Cita registrada con ID: " . $result->getInsertedId();
    } catch (Exception $e) {
       # echo "Error al registrar la cita: " . $e->getMessage();
    }
}
?>
