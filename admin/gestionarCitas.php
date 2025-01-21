<?php
    require("../comprobarAdmin.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="gestionarUsuario.css">
    <title>Gestionar Citas</title>
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
            document.getElementById('editCliente').value = row.querySelector('.cliente').innerText;
            document.getElementById('editFecha').value = row.querySelector('.fecha').innerText;
            document.getElementById('editHora').value = row.querySelector('.hora').innerText;
            document.getElementById('editObservaciones').value = row.querySelector('.observaciones').innerText;

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
    <div class="sidebar">
        <a href="indexAdmin.php#usuarios">Usuarios</a>
        <a href="indexAdmin.php#clientes">Clientes</a>
        <a href="indexAdmin.php#proveedores">Proveedores</a>
        <a href="indexAdmin.php#citas">Citas</a>
        <a href="indexAdmin.php#vehiculos">Vehículos</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Lista de citas</h1>
        </div>

    <?php
    require '../vendor/autoload.php';

    function updateCita($data) {
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->gestor->citas;

            $result = $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($data['id'])],
                ['$set' => [
                    'cliente' => $data['cliente'],
                    'fecha' => $data['fecha'],
                    'hora' => $data['hora'],
                    'observaciones' => $data['observaciones']
                ]]
            );

            return [
                'success' => $result->getModifiedCount() > 0,
                'message' => $result->getModifiedCount() > 0 ? "Cita actualizada con éxito." : "No se modificó ningún documento."
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = updateCita($_POST);
        $message = $result['message'];
    }
    ?>

    <?php if ($message): ?>
        <p style="color: <?= $result['success'] ? 'green' : 'red' ?>;">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <div id="modalOverlay" class="modal-overlay" onclick="closeModal()"></div>

    <div id="editModal" class="modal">
        <form method="POST">
            <input type="hidden" name="id" id="editId">
            <div>
                <label for="editCliente">Cliente:</label>
                <input type="text" name="cliente" id="editCliente" required>
            </div>
            <div>
                <label for="editFecha">Fecha:</label>
                <input type="date" name="fecha" id="editFecha" required>
            </div>
            <div>
                <label for="editHora">Hora:</label>
                <input type="time" name="hora" id="editHora" required>
            </div>
            <div>
                <label for="editObservaciones">Observaciones:</label>
                <textarea name="observaciones" id="editObservaciones" required></textarea>
            </div>

            <div>
                <button type="submit">Guardar</button>
                <button type="button" onclick="closeModal()">Cancelar</button>
            </div>
        </form>
    </div>

    <table>
        <tr>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Observaciones</th>
        </tr>
        <?php
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->gestor->citas;
            $result = $collection->find();

            foreach ($result as $entry) {
                echo "<tr onclick='openModal(this)' data-id='" . htmlspecialchars($entry->_id) . "'>";
                echo "<td class='cliente'>" . htmlspecialchars($entry->cliente) . "</td>";
                echo "<td class='fecha'>" . htmlspecialchars($entry->fecha) . "</td>";
                echo "<td class='hora'>" . htmlspecialchars($entry->hora) . "</td>";
                echo "<td class='observaciones'>" . htmlspecialchars($entry->observaciones) . "</td>";
                echo "</tr>";
            }
        } catch (Exception $e) {
            echo "<tr><td colspan='4'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
        ?>
    </table>
    </div>
</body>
</html>
