<?php
    require("../comprobarAdmin.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="css/gestionarUsuario.css">
    <script src="js/gestionarCitas.js"></script>
    <title>Gestionar Citas</title>

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
