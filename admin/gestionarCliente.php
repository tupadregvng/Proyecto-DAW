<?php
// Requiere MongoDB
require '../vendor/autoload.php';

// Cliente MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->gestor; // Nombre de la base de datos
$collection = $database->usuarios; // Nombre de la colección

// Maneja los formularios (POST para actualizar, GET para eliminar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se obtiene el ID del usuario a actualizar
    $id = $_POST['id'];

    // Datos de actualización del usuario
    $updateData = [
        'name' => $_POST['name'], // Nombre actualizado
        'email' => $_POST['email'], // Correo electrónico actualizado
        'role' => (int) $_POST['role'] // Rol actualizado (0 o 1)
    ];

    // Si se proporciona una nueva contraseña, se actualiza
    if (!empty($_POST['password'])) {
        $updateData['password'] = $_POST['password']; // Contraseña nueva
    }

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
    // ID del usuario a eliminar
    $id = $_GET['id'];

    // Elimina el usuario por su _id
    $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

    // Redirige a la misma página después de la eliminación
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Obtener todos los usuarios para mostrarlos en la tabla
$usuarios = $collection->find();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Clientes</title>
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="gestionarCliente.css">
</head>

<body>
    <div class="sidebar">
        <a href="indexAdmin.php#clientes">Clientes</a>
        <a href="indexAdmin.php#proveedores">Proveedores</a>
        <a href="indexAdmin.php#citas">Citas</a>
        <a href="indexAdmin.php#stock">Stock</a>
    </div>

    <div class="main-content">
        <h1>Lista de Usuarios</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Itera sobre todos los usuarios -->
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <!-- Formulario para editar el usuario -->
                        <form method="POST">
                            <!-- Mostrar ID del usuario -->
                            <td><?= htmlspecialchars($usuario['_id']) ?></td>

                            <!-- Campo para editar el nombre -->
                            <td><input type="text" name="name" value="<?= htmlspecialchars($usuario['name']) ?>"></td>

                            <!-- Campo para editar el correo electrónico -->
                            <td><input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>"></td>

                            <!-- Campo para cambiar la contraseña -->
                            <td><input type="password" name="password" placeholder="Nueva contraseña"></td>

                            <!-- Campo para seleccionar el rol -->
                            <td>
                                <select name="role">
                                    <option value="1" <?= $usuario['role'] == 1 ? 'selected' : '' ?>>Admin</option>
                                    <option value="0" <?= $usuario['role'] == 0 ? 'selected' : '' ?>>User</option>
                                </select>
                            </td>

                            <td>
                                <!-- Campo oculto para pasar el _id del usuario -->
                                <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['_id']) ?>">

                                <!-- Botón para enviar el formulario de actualización -->
                                <button type="submit">Guardar</button>

                        </form>

                        <!-- Formulario para eliminar el usuario -->
                        <form method="GET">
                            <!-- Campo oculto para pasar el _id del usuario para eliminarlo, esto permite trabajar con mas cosas que no sean inputs, como en este caso botones -->
                            <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['_id']) ?>">

                            <!-- Botón para eliminar al usuario -->
                            <button type="submit">Eliminar</button>
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>