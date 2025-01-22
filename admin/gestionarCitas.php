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

        function updateCita($data)
        {
            try {
                $client = new MongoDB\Client("mongodb://localhost:27017");
                $collection = $client->gestor->citas;

                $result = $collection->updateOne(
                    ['_id' => new MongoDB\BSON\ObjectId($data['id'])],
                    [
                        '$set' => [
                            'cliente' => $data['cliente'],
                            'fecha' => $data['fecha'],
                            'hora' => $data['hora'],
                            'observaciones' => $data['observaciones'],
                            'estado' => $data['estado'],
                        ]
                    ]
                );

                return [
                    #'success' => $result->getModifiedCount() > 0,
                    #'message' => $result->getModifiedCount() > 0 ? "Cita actualizada con éxito." : "No se modificó ningún documento."
                ];
            } catch (Exception $e) {
                # return ['success' => false, 'message' => $e->getMessage()];
            }
        }
        function deleteCita($id)
        {
            try {
                $client = new MongoDB\Client("mongodb://localhost:27017");
                $collection = $client->gestor->citas;

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
            $result = updateCita($_POST);
            # $message = $result['message'];
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteId'])) {
            $deleteId = $_POST['deleteId'];
            $result = deleteCita($deleteId);
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
                    <select name="hora" id="editHora" required>
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
                </div>
                <div>
                    <label for="editObservaciones">Observaciones:</label>
                    <textarea name="observaciones" id="editObservaciones" required></textarea>
                </div>

                <div>
                    <label for="editEstado">Estado:</label>
                    <select name="estado" id="editEstado" required>
                        <option value="Aceptado">Aceptado</option>
                        <option value="Pendiente">Pendiente</option>
                    </select>
                </div>

                <div>
                    <button type="submit">Guardar</button>
                    <button type="button" onclick="closeModal()">Cancelar</button>
                </div>
            </form>
        </div>

        <table id="tabla">
            <tr class="headerTabla">
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Observaciones</th>
                <th>Estado</th>
                <th>Eliminar</th>
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
                    echo "<td class='observaciones'>" . htmlspecialchars($entry->estado) . "</td>";
                    echo "<td>
                <form method='POST' action=''>
                    <input type='hidden' name='deleteId' value='" . htmlspecialchars($entry->_id) . "'>
                    <button type='submit' onclick='return confirm(\"¿Seguro que quieres eliminar esta cita?\")'>Eliminar</button>
                </form>
              </td>";
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