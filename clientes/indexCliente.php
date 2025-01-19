<?php
    session_start(); // Iniciar sesión
    $nombre = $_SESSION['name'];

    // Conectar a MongoDB
    require '../vendor/autoload.php'; // Cargar librería de MongoDB
    use MongoDB\Driver\Exception\Exception;
    $client = new MongoDB\Client("mongodb://localhost:27017");

    // Obtener citas de la base de datos
    $collection = $client->gestor->citas;
    $citas = $collection->find(['cliente' => $nombre]);

    //Obtener datos de motocicleta
    $collection = $client->gestor->motos;
    $motos = $collection->find(['cliente'=> $nombre]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="cliente.css">
    <script src="registroExito.js"></script>
    <title>Cliente</title>
</head>
<body>
    <!-- Menú lateral -->
    <div class="sidebar">
        <div>
            <a href="#misMoto">ESTADO DE MOTOCICLETA</a>
            <a href="#cita">CITAS</a>
            <a href="#pedir-cita">PEDIR CITA</a>
            <a href="../tiendaWeb.html">REALIZAR COMPRAS</a>
        </div>
        <!-- botón cerrar sesión -->
        <div class="cerrar">
            <a href="../index.php">Cerrar sessión</a>
        </div>
    </div>
    
    <div class="main-content">
        <!-- Título superior -->
        <div class="header">
            <?php
            echo"<h1>BIENVENIDO ".$nombre."</h1>"
            ?>
        </div>
        <!-- sección para la visualización del estado de la motocicleta -->
        <section id="misMoto">
            <h2>Mis motocicletas</h2>
            <p>Consulta aquí tus motociclestas y su estado.</p>
            <table>
                <tr class="headerTabla">
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Estado</th>
                </tr>
                <?php
                    foreach ($motos as $moto) {
                        echo "<tr>";
                            echo "<td>" . htmlspecialchars($moto['marca']) . "</td>";
                            echo "<td>" . htmlspecialchars($moto['modelo']) . "</td>";
                            echo "<td>" . htmlspecialchars($moto['estado']) . "</td>";
                        echo "</tr>";
                    }
                ?> 
            </table>
            <div id = "secBotones">
                <button onclick="window.location.href='gestionMotos.php'">Editar</button>
                <button onclick="window.location.href='nuevaMoto.php'">Añadir nueva motocicleta</button>  
            </div>  
        </section>
        

        <!-- citas -->
        <section id="cita">

            <!-- Visualizar citas -->
            <div id = "ver-citas">
                <h2>Citas previstas</h2>
                <table>
                    <tr class="headerTabla">
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                    </tr>
                    <?php
                        foreach ($citas as $cita) {
                            echo "<tr>";
                                echo "<td>" . htmlspecialchars($cita['fecha']) . "</td>";
                                echo "<td>" . htmlspecialchars($cita['hora']) . "</td>";
                                echo "<td>" . htmlspecialchars($cita['observaciones']) . "</td>";
                            echo "</tr>";
                        }
                    ?>    
                </table>
                <button onclick="window.location.href='gestionCitas.php'">Editar</button>
            </div>

            <!-- pedir cita -->
            <div id = "pedir-cita">
                <h2>Pedir Cita</h2>
                <p>Programa una cita para el mantenimiento o revisión de tu motocicleta.</p>
                <form id="registro-citas" action="pedirCita.php" method="POST">
                    <label for="fecha">Selecciona una fecha:</label>
                    <input type="date" id="fecha" name="fecha" required>
                    <br><br>
                    <label for="horas">Hora de la cita</label>
                    <select name="horas" id="horas" required>
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
                    <label for="observacion">Motivo de la cita</label>
                    <textarea id="observacion" name="observaciones"rows="4" cols="50" placeholder="Explica brevemente el problema de tu motocicleta..." required></textarea>
                    <button type="submit">Pedir cita</button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>