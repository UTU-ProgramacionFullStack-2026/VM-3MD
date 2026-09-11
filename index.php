<?php

session_start();

require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE email = '$email'";

    $resultado = $conn->execute_query($sql);
    $resultadoUsuario = $resultado->fetch_assoc();

    if (password_verify($password, $resultadoUsuario['password_hash'])) {
        $_SESSION['email'] = $email;
        $_SESSION['nombre'] = $resultadoUsuario['nombre'];
        $_SESSION['rol'] = $resultadoUsuario["rol"];

        header("Location: usuarios.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos</title>
</head>

<body>
    <h1>Bienvenidos al sistema de gestión de documentos</h1>

    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email">
        <label for="password">Contraseña:</label>
        <input type="password" name="password">
        <input type="submit" value="Enviar">
    </form>
</body>

</html>