<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
  <div class="login">
    <form  class= "form" action = "index.php" method = "POST">
      <input type="text" name="email" id="email" placeholder="Email" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" />
      <input type="password" name="password" id="password" placeholder="Contraseña" />
      <input type="submit" value="Log in" class="btnLogin"/>
    </form>
    <form action="registro.php" method="get">
      <input type="submit" value="Regístrate" class="btnRegistro"/>
    </form>
  </div>
</body>
</html>
<?php
require 'vendor/autoload.php'; // Cargar librería de MongoDB
use MongoDB\Driver\Exception\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Capturar datos del formulario
  $email = $_POST['email'];
  $password = $_POST['password'];

  try {
    // Conectar a MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->gestor->usuarios; // Acceder a la colección 'usuarios' en la base de datos 'gestor'

    // Buscar al usuario por correo electrónico
    $user = $collection->findOne(['email' => $email]);

    // Verificar si el usuario existe y la contraseña coincide
    if ($user && $user['password'] === $password) {
      // Almacenar información del usuario en la sesión
      $_SESSION['user_id'] = (string) $user['_id'];
      $_SESSION['name'] = $user['name'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['role'] = $user['role'];

      // Redirigir al dashboard
      if($user['role'] === 0){
        header('Location: clientes/indexCliente.php');
        exit();
      }else{
        header('Location: admin/indexAdmin.php');
        exit();
      }
    } else {
      $error = "Correo o contraseña inválidos.";
      echo ($error);
    }
  } catch (Exception $e) {
    $error = "Error al conectar con la base de datos: " . $e->getMessage();
  }
}
?>