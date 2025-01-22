<?php
    require("../comprobarAdmin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="css/indexAdmin.css">
    <title>Panel de administradores</title>
</head>

<body>
    <!-- Menú Lateral (Sidebar) -->
    <div class="sidebar">
        <a href="#clientes">Usuarios</a>
        <a href="#usuarios">Clientes</a>
        <a href="#proveedores">Proveedores</a>
        <a href="#citas">Citas</a>
        <a href="#vehiculos">Vehículos</a>

        <div class="cerrar">
            <a href="../index.php">Cerrar sessión</a>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="main-content">
        <div class="header">
            <h1>Panel de Administradores</h1>
        </div>
        <section id="Usuarios">
            <h2>Usuarios</h2>
            <p>Aquí podrás gestionar todos los usuarios registrados en el sistema.</p>
            <button onclick="window.location.href='nuevoUsuario.php';">Añadir nuevo Usuario</button>
            <button onclick="window.location.href='gestionarUsuario.php';">Ver y Gestionar Usuarios</button>
        </section>

        <section id="Clientes">
            <h2>Clientes</h2>
            <p>Aquí podrás gestionar todos los clientes registrados en el sistema.</p>
            <button onclick="window.location.href='nuevoCliente.php';">Añadir nuevo cliente</button>
            <button onclick="window.location.href='gestionarCliente.php';">Ver y Gestionar Clientes</button>
        </section>

        <section id="proveedores">
            <h2>Proveedores</h2>
            <p>Aquí podrás gestionar los proveedores asociados a tu empresa.</p>
            <button onclick="window.location.href='nuevoProveedor.php';">Añadir nuevo proveedor</button>
            <button onclick="window.location.href='gestionarProovedor.php';">Gestionar proovedores</button>
        </section>

        <section id="citas">
            <h2>Citas</h2>
            <p>Aquí podrás gestionar las citas de los clientes y las reparaciones pendientes.</p>
            <button onclick="window.location.href='nuevaCita.php';">Añadir cita</button>
            <button onclick="window.location.href='gestionarCitas.php';">Gestionar citas</button>
        </section>

        <section id="vehiculos">
            <h2>Vehiculos</h2>
            <p>Aquí podrás ver y administrar el inventario de productos o piezas disponibles.</p>
            <button onclick="window.location.href='nuevaMoto.php';">Añadir nuevo vehiculo</button>
            <button onclick="window.location.href='gestionarMoto.php';">Gestionar Vehiculos</button>
        </section>
    </div>
</body>
</html>