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
    <script src="js/gestionarMoto.js"></script>
    <title>Gestionar Motos</title>
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
            <h1>Lista de Motos</h1>
        </div>

    <?php
    require '../vendor/autoload.php';

    function updateMoto($data) {
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->gestor->motos;

            $result = $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($data['id'])],
                ['$set' => [
                    'cliente' => $data['cliente'],
                    'marca' => $data['marca'],
                    'modelo' => $data['modelo'],
                    'bastidor' => $data['bastidor'],
                    'matricula' => $data['matricula'],
                    'notas' => $data['notas'],
                    'estado' => $data['estado']
                ]]
            );

            return [
                #'success' => $result->getModifiedCount() > 0,
                #'message' => $result->getModifiedCount() > 0 ? "Moto actualizada con éxito." : "No se modificó ningún documento."
            ];
        } catch (Exception $e) {
            # return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    function deleteMoto($id)
    {
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->gestor->motos;

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
        $result = updateMoto($_POST);
        # $message = $result['message'];
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteId'])) {
        $deleteId = $_POST['deleteId'];
        $result = deleteMoto($deleteId);
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
                <label for="editCliente">Cliente:</label>
                <input type="text" name="cliente" id="editCliente" required>
            </div>
            <div>
                <label for="editMarca">Marca:</label>
                <input type="text" name="marca" id="editMarca" required>
            </div>
            <div>
                <label for="editModelo">Modelo:</label>
                <input type="text" name="modelo" id="editModelo" required>
            </div>
            <div>
                <label for="editBastidor">Bastidor:</label>
                <input type="text" name="bastidor" id="editBastidor"  pattern="^[A-Za-z0-9]{17}$" required>
            </div>
            <div>
                <label for="editMatricula">Matrícula:</label>
                <input type="text" name="matricula" id="editMatricula"  pattern="(^\d{4}\s?[A-Z]{3}$)" required>
            </div>
            <div>
                <label for="editNotas">Notas:</label>
                <textarea name="notas" id="editNotas"></textarea>
            </div>
            <div>
                <label for="editEstado">Estado:</label>
                <input type="text" name="estado" id="editEstado" required>
            </div>
            <div>
                <button type="submit">Guardar</button>
                <button type="button" onclick="closeModal()">Cancelar</button>
            </div>
        </form>
    </div>

    <table>
        <tr class="headerTabla">
            <th>Cliente</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Bastidor</th>
            <th>Matrícula</th>
            <th>Notas</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Eliminar</th>
        </tr>
        <?php
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->gestor->motos;
            $result = $collection->find();

            foreach ($result as $entry) {
                $timestamp = $entry->timestamp->toDateTime();
                echo "<tr onclick='openModal(this)' data-id='" . htmlspecialchars($entry->_id) . "'>";
                echo "<td class='cliente'>" . htmlspecialchars($entry->cliente) . "</td>";
                echo "<td class='marca'>" . htmlspecialchars($entry->marca) . "</td>";
                echo "<td class='modelo'>" . htmlspecialchars($entry->modelo) . "</td>";
                echo "<td class='bastidor'>" . htmlspecialchars($entry->bastidor) . "</td>";
                echo "<td class='matricula'>" . htmlspecialchars($entry->matricula) . "</td>";
                echo "<td class='notas'>" . htmlspecialchars($entry->notas) . "</td>";
                echo "<td class='estado'>" . htmlspecialchars($entry->estado) . "</td>";
                echo "<td>" . $timestamp->format('d/m/Y H:i') . "</td>";
                echo "<td>
                <form method='POST' action=''>
                    <input type='hidden' name='deleteId' value='" . htmlspecialchars($entry->_id) . "'>
                    <button type='submit' onclick='return confirm(\"¿Seguro que quieres eliminar esta moto?\")'>Eliminar</button>
                </form>
              </td>";
                echo "</tr>";
            }
        } catch (Exception $e) {
            echo "<tr><td colspan='8'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
        ?>
    </table>
    </div>
</body>
</html>
