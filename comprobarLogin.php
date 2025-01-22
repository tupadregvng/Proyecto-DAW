<?php
    session_start(); // Iniciar sesión
    $nombre = $_SESSION['name'];
    
    if(!isset($nombre)){
        echo "<script>alert('No tienes acceso a esta página.'); window.location.href = '../index.php';</script>";
    }
?>