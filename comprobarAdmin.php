<?php
    session_start(); // Iniciar sesión
    $nombre = $_SESSION['name'];
    $role = $_SESSION['role'];
    if(!isset($nombre) || $role !== 1){
        echo "<script>alert('No tienes acceso a esta página.'); window.location.href = '../index.php';</script>";
    }
?>