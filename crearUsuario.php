<?php

require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];

    $sql = "INSERT INTO usuario(nombre, email, rol)
        VALUES ('$nombre', '$email', '$rol')";

    $resultado = $conn->execute_query($sql);
} else {
    echo "recibi GET";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear usuario</title>
</head>

<body>

    <h1>Crear usuario</h1>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre">
        <label for="email">Email:</label>
        <input type="email" name="email">
        <label for="rol"></label>
        <input type="text" name="rol">

        <input type="submit" value="Crear nuevo usuario">


    </form>
</body>

</html>