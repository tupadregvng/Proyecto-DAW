<?php
require 'vendor/autoload.php'; // Incluir la librería de MongoDB

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->registro->usuarios;

// Si el formulario se envía, realizamos alguna acción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Comprobar si estamos añadiendo un nuevo usuario
    if (isset($_POST['add_user'])) {
        // Si se va a añadir un usuario, tomamos los datos del formulario
        $collection->insertOne([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'role' => (int)$_POST['role'] // Asignamos el rol que nos manden (0 para usuario, 1 para admin)
        ]);
    } 
    // Si estamos eliminando un usuario
    elseif (isset($_POST['delete_user'])) {
        // Eliminamos al usuario usando su ID
        $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($_POST['user_id'])]);
    } 
    // Si estamos editando un usuario
    elseif (isset($_POST['edit_user'])) {
        // Actualizamos el usuario con los nuevos datos (nombre, email, contraseña y rol)
        $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($_POST['user_id'])],
            ['$set' => [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role' => (int)$_POST['role'] // Actualizamos el rol (puede ser 0 o 1)
            ]]
        );
    }
}

// Traemos todos los usuarios de la base de datos para mostrarlos
$users = $collection->find();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Usuarios</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <!-- Mostramos el nombre, email y rol del usuario -->
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= $user['role'] == 1 ? 'Administrador' : 'Usuario' ?></td>
                    <td>
                        <!-- Botón para eliminar usuario -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $user['_id'] ?>">
                            <button type="submit" name="delete_user">Eliminar</button>
                        </form>
                        <!-- Formulario para editar un usuario -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $user['_id'] ?>">
                            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" placeholder="Nuevo nombre" required>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Nuevo email" required>
                            <input type="text" name="password" value="<?= htmlspecialchars($user['password']) ?>" placeholder="Nueva contraseña" required>
                            <select name="role">
                                <!-- Aquí elegimos el rol, si es 0, será Usuario, si es 1, será Admin -->
                                <option value="0" <?= $user['role'] == 0 ? 'selected' : '' ?>>Usuario</option>
                                <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Administrador</option>
                            </select>
                            <button type="submit" name="edit_user">Editar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Añadir Usuario</h2>
    <!-- Formulario para añadir un nuevo usuario -->
    <form method="POST">
        <label>Nombre: <input type="text" name="name" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Contraseña: <input type="password" name="password" required></label><br>

        <!-- Seleccionamos el rol para el nuevo usuario -->
        <label>Rol:
            <select name="role" required>
                <option value="0">Usuario</option>
                <option value="1">Administrador</option>
            </select>
        </label><br>

        <button type="submit" name="add_user">Añadir</button>
    </form>
</body>
</html>
