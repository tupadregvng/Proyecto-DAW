<?php
    session_start(); // Iniciar sesión
    $nombre = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="nuevaMoto.css">
    <title>nueva Moto</title>
</head>
<body>
    <!-- Menú lateral -->
    <div class="sidebar">
        <a href="#misMoto">ESTADO DE MOTOCICLETA</a>
        <a href="#cita">CITAS</a>
        <a href="#pedir-cita">PEDIR CITA</a>
        <a href="../tiendaWeb.html">REALIZAR COMPRAS</a>
    </div>
    <div class="main-content">
        <!-- Título superior -->
        <div class="header">
            <?php
            echo"<h1>BIENVENIDO ".$nombre."</h1>"
            ?>
        </div>
        <form action="indexCliente.php" method="post">
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" required>

            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" required>

            <label for="bastidor">Nº Bastidor:</label>
            <input type="text" id="bastidor" name="bastidor" required>

            <label for="matricula">Matrícula:</label>
            <input type="text" id="matricula" name="matricula" required>


            <label for="notas">Notas adicionales:</label>
            <textarea id="notas" name="notas" rows="4" cols="50"></textarea>

            <button type="submit">Guardar</button>
        </form>
    </div>
</body>
</html>