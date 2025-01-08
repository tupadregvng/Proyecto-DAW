<?php
    require '../vendor/autoload.php'; // Cargar librería de MongoDB
    use MongoDB\Driver\Exception\Exception;

    session_start(); // Iniciar sesión para almacenar información del usuario

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fecha'], $_POST['horas'], $_POST['observaciones'])) {
        $fecha = $_POST['fecha'];
        $hora = $_POST['horas'];
        $observacion = $_POST['observaciones'];
    }
    try {
        // Conectar a MongoDB
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $collection = $client->clientes->citas; 
        
        // Insertar datos en la base de datos
        $result = $collection->insertOne([
            'dia' => $fecha,
            'hora' => $hora, 
            'observaciones' => $observacion,
        ]);
        header("Location: indexCliente.php?registro=exito");
    } catch (Exception $e) {
        $error = "Error al conectar con la base de datos: " . $e->getMessage();
    }
?>