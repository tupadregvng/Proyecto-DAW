<?php
session_start(); // Iniciar sesión
$nombre = $_SESSION['name'];

// Requiere MongoDB
require '../vendor/autoload.php';

// Cliente MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->gestor->motos;

// Maneja los formularios (POST para actualizar, GET para eliminar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se obtiene el ID a actualizar
    $id = $_POST['id'];

    // Datos de actualización
    $updateData = [
        'marca' => $_POST['marca'], 
        'modelo' => $_POST['modelo'], 
        'bastidor' => $_POST['bastidor'],
        'matricula' => $_POST['matricula'],
        'notas' => $_POST['notas'],
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

    // Elimina el objeto por su _id
    $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

    // Redirige a la misma página después de la eliminación
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Obtener todos los objetos para mostrarlos en la tabla
$motos = $collection->find(['cliente'=> $nombre]);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Clientes</title>
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="gestion.css">
    <script src="funciones.js" defer></script>
</head>

<body>
    <div class="sidebar">
        <a href="indexCliente.php#misMoto">ESTADO DE MOTOCICLETA</a>
        <a href="indexCliente.php#cita">CITAS</a>
        <a href="indexCliente.php#pedir-cita">PEDIR CITA</a>
        <a href="../tiendaWeb.html">REALIZAR COMPRAS</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Mis motocicletas</h1>
        </div>
        <table>
            <thead class="headerTabla">
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Bastidor</th>
                    <th>Matricula</th>
                    <th>Notas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($motos as $moto): ?>
                    <tr>
                        <!-- Formulario para editar la moto -->
                        <form method="POST">
                            <!-- Campo para editar la marca -->
                            <td><input type="marca" name="marca" value="<?= htmlspecialchars($moto['marca']) ?>"></td>

                            <!-- Campo para editar el modelo -->
                            <td><input type="modelo" name="modelo" value="<?= htmlspecialchars($moto['modelo']) ?>"></td>

                            <!-- Campo para cambiar el bastidor -->
                            <td><input type="bastidor" name="bastidor" value="<?= htmlspecialchars($moto['bastidor']) ?>"></td>

                            <!-- Campo para cambiar la matricula -->
                            <td><input type="matricula" name="matricula" value="<?= htmlspecialchars($moto['matricula']) ?>"></td>
                            
                            <!-- Campo para cambiar la descripción-->
                            <td><input type="notas" name="notas" value="<?= htmlspecialchars($moto['notas']) ?>"></td>
                            <td>
                                <!-- Campo oculto para pasar el _id de la moto -->
                                <input type="hidden" name="id" value="<?= htmlspecialchars($moto['_id']) ?>">

                                <!-- Botón para enviar el formulario de actualización -->
                                <button type="submit">Guardar</button>

                        </form>

                        <!-- Formulario para eliminar el usuario -->
                        <form method="GET">
                            <!-- Campo oculto para pasar el _id de la moto para eliminarla, esto permite trabajar con mas cosas que no sean inputs, como en este caso botones -->
                            <input type="hidden" name="id" value="<?= htmlspecialchars($moto['_id']) ?>">

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