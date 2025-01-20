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
    <title>Gestionar Motos</title>
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
            document.getElementById('editMarca').value = row.querySelector('.marca').innerText;
            document.getElementById('editModelo').value = row.querySelector('.modelo').innerText;
            document.getElementById('editBastidor').value = row.querySelector('.bastidor').innerText;
            document.getElementById('editMatricula').value = row.querySelector('.matricula').innerText;
            document.getElementById('editNotas').value = row.querySelector('.notas').innerText;
            document.getElementById('editEstado').value = row.querySelector('.estado').innerText;

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
<h1>Lista de Motos</h1>
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
                'success' => $result->getModifiedCount() > 0,
                'message' => $result->getModifiedCount() > 0 ? "Moto actualizada con éxito." : "No se modificó ningún documento."
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = updateMoto($_POST);
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
                <input type="text" name="bastidor" id="editBastidor" required>
            </div>
            <div>
                <label for="editMatricula">Matrícula:</label>
                <input type="text" name="matricula" id="editMatricula" required>
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
        <tr>
            <th>Cliente</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Bastidor</th>
            <th>Matrícula</th>
            <th>Notas</th>
            <th>Estado</th>
            <th>Fecha</th>
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
                echo "</tr>";
            }
        } catch (Exception $e) {
            echo "<tr><td colspan='8'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
