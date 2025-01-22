<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="css/gestionarUsuario.css">
    <script src="js/gestionarCliente.js"></script>
    <title>Gestionar Clientes</title>

</head>
<body>
    <!-- Menú Lateral (Sidebar) -->
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
            <h1>Lista de clientes</h1>
        </div>

    <?php
    require '../vendor/autoload.php';

    function updateCliente($data) {
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->gestor->cliente;

            $result = $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($data['id'])],
                ['$set' => [
                    'nombre' => $data['nombre'],
                    'apellidos' => $data['apellidos'],
                    'telefono' => $data['telefono'],
                    'email' => $data['email'],
                    'direccion' => $data['direccion'],
                ]]
            );

            return [
                #'success' => $result->getModifiedCount() > 0,
                #'message' => $result->getModifiedCount() > 0 ? "Cliente actualizado con éxito." : "No se modificó ningún documento."
            ];
        } catch (Exception $e) {
            # return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    function deleteCliente($id)
    {
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->gestor->cliente;

            $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            header('Location: ' . $_SERVER['PHP_SELF']);

            return [
                # 'success' => $result->getDeletedCount() > 0,
                # 'message' => $result->getDeletedCount() > 0 ? "Cita eliminada con éxito." : "No se encontró la cita para eliminar."
            ];
        } catch (Exception $e) {
            # return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = updateCliente($_POST);
        # $message = $result['message'];
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteId'])) {
        $deleteId = $_POST['deleteId'];
        $result = deleteCliente($deleteId);
    }
    ?>

    <?php if ($message): ?>
        <p style="color: <?= $result['success'] ? 'green' : 'red' ?>;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <div id="modalOverlay" class="modal-overlay" onclick="closeModal()"></div>

    <div id="editModal" class="modal">
        <form method="POST">
            <input type="hidden" name="id" id="editId">
            <div>
                <label for="editNombre">Nombre:</label>
                <input type="text" name="nombre" id="editNombre" required>
            </div>
            <div>
                <label for="editApellidos">Apellidos:</label>
                <input type="text" name="apellidos" id="editApellidos" required>
            </div>
            <div>
                <label for="editTelefono">Teléfono:</label>
                <input type="text" name="telefono" id="editTelefono"  pattern = "^\+?[0-9]+$" required>
            </div>
            <div>
                <label for="editEmail">Email:</label>
                <input type="email" name="email" id="editEmail"  pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" required>
            </div>
            <div>
                <label for="editDireccion">Dirección:</label>
                <input type="text" name="direccion" id="editDireccion" required>
            </div>

            <div>
                <button type="submit">Guardar</button>
                <button type="button" onclick="closeModal()">Cancelar</button>
            </div>
        </form>
    </div>

    <table>
        <tr class="headerTabla">
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Eliminar</th>
        </tr>
        <?php
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->gestor->cliente;
            $result = $collection->find();

            foreach ($result as $entry) {
                echo "<tr onclick='openModal(this)' data-id='" . htmlspecialchars($entry->_id) . "'>";
                echo "<td class='nombre'>" . htmlspecialchars($entry->nombre) . "</td>";
                echo "<td class='apellidos'>" . htmlspecialchars($entry->apellidos) . "</td>";
                echo "<td class='telefono'>" . htmlspecialchars($entry->telefono) . "</td>";
                echo "<td class='email'>" . htmlspecialchars($entry->email) . "</td>";
                echo "<td class='direccion'>" . htmlspecialchars($entry->direccion) . "</td>";
                echo "<td>
                <form method='POST' action=''>
                    <input type='hidden' name='deleteId' value='" . htmlspecialchars($entry->_id) . "'>
                    <button type='submit' onclick='return confirm(\"¿Seguro que quieres eliminar este cliente?\")'>Eliminar</button>
                </form>
              </td>";
                echo "</tr>";
            }
        } catch (Exception $e) {
            echo "<tr><td colspan='6'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
        ?>
    </table>
    </div>
</body>
</html>
