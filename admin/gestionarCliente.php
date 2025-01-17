<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="gestionarUsuario.css">
    <title>Gestionar Clientes</title>
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .modal.active {
            display: block;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .modal-overlay.active {
            display: block;
        }
    </style>
    <script>
        function openModal(row) {
            const modal = document.getElementById('editModal');
            const overlay = document.getElementById('modalOverlay');

            // Fill form fields with row data
            document.getElementById('editId').value = row.dataset.id;
            document.getElementById('editNombre').value = row.querySelector('.nombre').innerText;
            document.getElementById('editTelefono').value = row.querySelector('.telefono').innerText;
            document.getElementById('editEmail').value = row.querySelector('.email').innerText;
            document.getElementById('editDireccion').value = row.querySelector('.direccion').innerText;

            modal.classList.add('active');
            overlay.classList.add('active');
        }

        function closeModal() {
            document.getElementById('editModal').classList.remove('active');
            document.getElementById('modalOverlay').classList.remove('active');
        }
    </script>
</head>
<body>
<h1>Lista de Clientes</h1>
    <?php
    require '../vendor/autoload.php';

    function updateCliente($data) {
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->gestor->clientes;

            $result = $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($data['id'])],
                ['$set' => [
                    'nombre' => $data['nombre'],
                    'telefono' => $data['telefono'],
                    'email' => $data['email'],
                    'direccion' => $data['direccion'],
                    'notas' => $data['notas']
                ]]
            );

            return [
                'success' => $result->getModifiedCount() > 0,
                'message' => $result->getModifiedCount() > 0 ? "Cliente actualizado con éxito." : "No se modificó ningún documento."
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = updateCliente($_POST);
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
                <button type="submit">Guardar</button>
                <button type="button" onclick="closeModal()">Cancelar</button>
            </div>
        </form>
    </div>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Notas</th>
            <th>Fecha</th>
        </tr>
        <?php
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->gestor->cliente;
            $result = $collection->find();

            foreach ($result as $entry) {
                echo "<tr onclick='openModal(this)' data-id='" . htmlspecialchars($entry->_id) . "'>";
                echo "<td class='nombre'>" . htmlspecialchars($entry->nombre) . "</td>";
                echo "<td class='telefono'>" . htmlspecialchars($entry->telefono) . "</td>";
                echo "<td class='email'>" . htmlspecialchars($entry->email) . "</td>";
                echo "<td class='direccion'>" . htmlspecialchars($entry->direccion) . "</td>";
                echo "</tr>";
            }
        } catch (Exception $e) {
            echo "<tr><td colspan='6'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
