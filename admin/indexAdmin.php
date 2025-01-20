<?php
    session_start(); // Iniciar sesión
    $nombre = $_SESSION['name'];
    $role = $_SESSION['role'];
    if(!isset($nombre) || $role !== "admin"){
        echo "<script>alert('No tienes acceso a esta página.'); window.location.href = '../index.php';</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilosGenerales.css">
    <link rel="stylesheet" href="indexAdmin.css">
    <title>Panel de administradores</title>
</head>

<body>

    <!-- Menú Lateral (Sidebar) -->
    <div class="sidebar">
        <a href="#clientes">Clientes</a>
        <a href="#proveedores">Proveedores</a>
        <a href="#citas">Citas</a>
        <a href="#stock">Stock</a>
    
    </div>

    <!-- Contenido Principal -->
    <div class="main-content">
        <div class="header">
            <h1>Panel de Administradores</h1>
        </div>
        <section id="clientes">
            <h2>Clientes</h2>
            <p>Aquí podrás gestionar todos los clientes registrados en el sistema.</p>
            <button onclick="window.location.href='nuevoCliente.php';">Añadir nuevo cliente</button>
            <button onclick="window.location.href='gestionarCliente.php';">Ver y Gestionar Clientes</button>
        </section>

        <section id="proveedores">
            <h2>Proveedores</h2>
            <p>Aquí podrás gestionar los proveedores asociados a tu empresa.</p>
            <button onclick="window.location.href='nuevoProveedor.php';">Añadir nuevo proveedor</button>
        </section>

        <section id="citas">
            <h2>Citas</h2>
            <p>Aquí podrás gestionar las citas de los clientes y las reparaciones pendientes.</p>
            <button onclick="window.location.href='citas.php';">Gestionar citas</button>
        </section>

        <section id="stock">
            <h2>Stock</h2>
            <p>Aquí podrás ver y administrar el inventario de productos o piezas disponibles.</p>
            <button onclick="window.location.href='nuevoRecambio.php';">Añadir nuevo recambio</button>
        </section>
    </div>
</body>
</html>