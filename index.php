<?php

require_once('db.php');
$sql = "SELECT * FROM usuario";
$resultado = $conn->execute_query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de usuarios</title>
</head>

<body>
    <a href="crearEditarUsuario.php">Nuevo usuario</a>
    <table>
        <thead>
            <tr>
                <td>Nombre</td>
                <td>Mail</td>
                <td>Rol</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultado as $fila): ?>
                <tr>
                    <!-- <td><?php echo $fila['usuario_id']; ?></td> -->
                    <td><?= $fila['nombre']; ?></td>
                    <td><?= $fila['email']; ?></td>
                    <td><?= $fila['rol']; ?></td>
                    <td><a href="crearEditarUsuario.php?id=<?php echo $fila['usuario_id']; ?>">Editar</a> <a href="#">Borrar</a></td>
                </tr>

            <?php endforeach ?>


        </tbody>

    </table>

</body>

</html>