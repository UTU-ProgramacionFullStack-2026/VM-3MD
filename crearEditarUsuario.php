<?php

require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    //estoy editando o creando?
    //si tengo id, estoy EDITANDO
    if (isset($_POST['usuario_id'])) {
        $id = $_POST['usuario_id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];

        $sqlUpdate = "UPDATE usuario 
        SET nombre = '$nombre',
        email = '$email',
        rol = '$rol'
        WHERE usuario_id = '$id'
        ";

        $resultadoUpdate = $conn->execute_query($sqlUpdate);

        header("Location: index.php");
        exit;
    } else {
        //si no tengo id, estoy CREANDO un usuario


        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];


        $sql = "INSERT INTO usuario(nombre, email, rol)
        VALUES ('$nombre', '$email', '$rol')";

        $resultado = $conn->execute_query($sql);
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if (isset($_GET['id'])) {
        $idUsuario = $_GET['id'];
        $sqlUsuario = "SELECT * FROM usuario WHERE usuario_id ='$idUsuario';";
        $resultadoUsuario = $conn->execute_query($sqlUsuario);
        $datosUsuario = $resultadoUsuario->fetch_assoc();
    }
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
        <input
            type="text"
            name="nombre"
            value="
            <?php if (isset($datosUsuario['nombre'])) {
                echo $datosUsuario['nombre'];
            } ?>
        ">
        <label for="email">Email:</label>
        <input type="email" name="email"
            value="
            <?php if (isset($datosUsuario['email'])) {
                echo $datosUsuario['email'];
            } ?>
        ">
        <label for="rol">Rol:</label>
        <input type="text" name="rol"
            value="
            <?php if (isset($datosUsuario['rol'])) {
                echo $datosUsuario['rol'];
            } ?>
        ">

        <input type="hidden" name="usuario_id"
            value="
            <?php if (isset($datosUsuario['usuario_id'])) {
                echo $datosUsuario['usuario_id'];
            } ?>
        ">

        <input type="submit" value="
        <?php if (isset($datosUsuario['nombre'])) {
            echo "Editar usuario";
        } else {
            echo "Crear nuevo usuario";
        } ?>
        ">


    </form>
</body>

</html>