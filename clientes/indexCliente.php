<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="indexCliente.css">
    <script src="registroExitoCita.js"></script>
    <title>Cliente</title>
</head>
<body>
    <div class="sidebar">
            <a href="#estado-motocicleta">ESTADO DE MOTOCICLETA</a>
            <a href="#cita">CITAS</a>
            <a href="../tiendaWeb.html">REALIZAR COMPRAS</a>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>BIENVENIDO CLIENTE</h1>
        </div>
        
        <section id="estado-motocicleta">
            <h2>Estado de Motocicleta</h2>
            <p>Consulta aquí el estado de tu motocicleta.</p>
            <table>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Estado</th>
                </tr>
              </table>
        </section>
        <section id="cita">
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
        </section>
    </div>
</body>
</html>