<?php
require("../comprobarLogin.php");

// Requiere MongoDB
require '../vendor/autoload.php';

// Cliente MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->gestor->citas;

// Maneja los formularios (POST para actualizar, GET para eliminar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se obtiene el ID a actualizar
    $id = $_POST['id'];

    // Datos de actualización
    $updateData = [
        'fecha' => $_POST['fecha'], 
        'hora' => $_POST['hora'], 
        'observaciones' => $_POST['observaciones'],
    ];

    // Actualiza el usuario en la base de datos usando su _id como identificador.
    // Los métodos de coleccion de MongoDB funcionan pasando el valor que se quiere cambiar como objeto, aqui definimos un nuevo objeto BSON de MongoDB con el $id que hemos cogido antes
    // Una vez hace un clave:valor _id:objeto, sabe que objeto es dentro de la coleccion y en este caso se pasa el parametro $set apuntando a $updateData para refleje en la BBDD los datos capturados en $updateData
    $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($id)],
        ['$set' => $updateData]
    );

    // Redirige a la misma página para reflejar los cambios
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // ID a eliminar
    $id = $_GET['id'];
    
    // Elimina el objeto por su _id si se ha confirmado la ventana emergente
    $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

    // Redirige a la misma página después de la eliminación
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Obtener los objetos para mostrarlos en la tabla
$citas = $collection->find(['cliente'=> $nombre]);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Clientes</title>
    <link rel="stylesheet" href="../estilosGenerales.css">
    <script src="funciones.js" defer></script>
</head>

<body>
    <div class="sidebar">
        <a href="indexCliente.php#misMoto">ESTADO DE MOTOCICLETA</a>
        <a href="indexCliente.php#cita">CITAS</a>
        <a href="indexCliente.php#pedir-cita">PEDIR CITA</a>
        <a href="../tiendaWeb.html">REALIZAR COMPRAS</a>

        <!-- botón cerrar sesión -->
        <div class="cerrar">
            <a href="../index.php">Cerrar sessión</a>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Citas previstas</h1>
        </div>
        <table>
            <thead class ="headerTabla">
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Motivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($citas as $cita): ?>
                    <tr>
                        <!-- Formulario para editar la cita -->
                        <form method="POST">
                            <!-- Campo para editar la fecha -->
                            <td><input type="fecha" name="fecha" value="<?= htmlspecialchars($cita['fecha']) ?>"></td>

                            <!-- Campo para editar la hora -->
                            <td>
                                <select name="hora">
                                <option value="8:00"<?= $cita['hora'] == '8:00' ? ' selected' : '' ?>>8:00</option>
                                <option value="8:30"<?= $cita['hora'] == '8:30' ? ' selected' : '' ?>>8:30</option>
                                <option value="9:00"<?= $cita['hora'] == '9:00' ? ' selected' : '' ?>>9:00</option>
                                <option value="9:30"<?= $cita['hora'] == '9:30' ? ' selected' : '' ?>>9:30</option>
                                <option value="10:00"<?= $cita['hora'] == '10:00' ? ' selected' : '' ?>>10:00</option>
                                <option value="10:30"<?= $cita['hora'] == '10:30' ? ' selected' : '' ?>>10:30</option>
                                <option value="11:00"<?= $cita['hora'] == '11:00' ? ' selected' : '' ?>>11:00</option>
                                <option value="11:30"<?= $cita['hora'] == '11:30' ? ' selected' : '' ?>>11:30</option>
                                <option value="12:00"<?= $cita['hora'] == '12:00' ? ' selected' : '' ?>>12:00</option>
                                <option value="12:30"<?= $cita['hora'] == '12:30' ? ' selected' : '' ?>>12:30</option>
                                <option value="13:00"<?= $cita['hora'] == '13:00' ? ' selected' : '' ?>>13:00</option>
                                <option value="13:30"<?= $cita['hora'] == '13:30' ? ' selected' : '' ?>>13:30</option>
                                <option value="14:00"<?= $cita['hora'] == '14:00' ? ' selected' : '' ?>>14:00</option>
                                <option value="14:30"<?= $cita['hora'] == '14:30' ? ' selected' : '' ?>>14:30</option>
                                <option value="15:00"<?= $cita['hora'] == '15:00' ? ' selected' : '' ?>>15:00</option>
                                </select>
                            </td>

                            <!-- Campo para cambiar el motivo -->
                            <td><input  class= "motivo" type="observaciones" name="observaciones" value="<?= htmlspecialchars($cita['observaciones']) ?>"></td>
                            <td>
                                <!-- Campo oculto para pasar el _id -->
                                <input type="hidden" name="id" value="<?= htmlspecialchars($cita['_id']) ?>">

                                <!-- Botón para enviar el formulario de actualización -->
                                <button type="submit">Guardar</button>

                        </form>

                        <!-- Formulario para eliminar -->
                        <form method="GET">
                            <!-- Campo oculto para pasar el _id de la cita para eliminarla, esto permite trabajar con mas cosas que no sean inputs, como en este caso botones -->
                            <input type="hidden" name="id" value="<?= htmlspecialchars($cita['_id']) ?>">

                            <!-- Botón para eliminar -->
                            <button type="button" onclick="confirmarEliminar()">Eliminar</button>
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>