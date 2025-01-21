<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="css/gestionarUsuario.css">
    <script src="js/gestionarProovedor.js"></script>
    <title>Gestionar Proovedores</title>
</head>
<body>
<h1>Lista de Proovedores</h1>
    <?php
    require '../vendor/autoload.php';

    function updateProveedor($data) {
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->gestor->proovedores;

            $result = $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($data['id'])],
                ['$set' => [
                    'nombre' => $data['nombre'],
                    'contacto' => $data['contacto'],
                    'telefono' => $data['telefono'],
                    'email' => $data['email'],
                    'direccion' => $data['direccion'],
                    'notas' => $data['notas']
                ]]
            );

            return [
                'success' => $result->getModifiedCount() > 0,
                'message' => $result->getModifiedCount() > 0 ? "Proveedor actualizado con éxito." : "No se modificó ningún documento."
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = updateProveedor($_POST);
        $message = $result['message'];
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
                <label for="editContacto">Contacto:</label>
                <input type="text" name="contacto" id="editContacto" required>
            </div>
            <div>
                <label for="editTelefono">Teléfono:</label>
                <input type="text" name="telefono" id="editTelefono" required>
            </div>
            <div>
                <label for="editEmail">Email:</label>
                <input type="email" name="email" id="editEmail" required>
            </div>
            <div>
                <label for="editDireccion">Dirección:</label>
                <input type="text" name="direccion" id="editDireccion" required>
            </div>
            <div>
                <label for="editNotas">Notas:</label>
                <textarea name="notas" id="editNotas"></textarea>
            </div>
            <div>
                <button type="submit">Guardar</button>
                <button type="button" onclick="closeModal()">Cancelar</button>
            </div>
        </form>
    </div>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Contacto</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Notas</th>
            <th>Fecha</th>
        </tr>
        <?php
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->gestor->proovedores;
            $result = $collection->find();

            foreach ($result as $entry) {
                $timestamp = $entry->timestamp->toDateTime();
                echo "<tr onclick='openModal(this)' data-id='" . htmlspecialchars($entry->_id) . "'>";
                echo "<td class='nombre'>" . htmlspecialchars($entry->nombre) . "</td>";
                echo "<td class='contacto'>" . htmlspecialchars($entry->contacto) . "</td>";
                echo "<td class='telefono'>" . htmlspecialchars($entry->telefono) . "</td>";
                echo "<td class='email'>" . htmlspecialchars($entry->email) . "</td>";
                echo "<td class='direccion'>" . htmlspecialchars($entry->direccion) . "</td>";
                echo "<td class='notas'>" . htmlspecialchars($entry->notas) . "</td>";
                echo "<td>" . $timestamp->format('d/m/Y H:i') . "</td>";
                echo "</tr>";
            }
        } catch (Exception $e) {
            echo "<tr><td colspan='7'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
