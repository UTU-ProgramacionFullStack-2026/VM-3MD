<?php

require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    //estoy editando o creando?
    //si tengo id, estoy EDITANDO

    if (isset($_POST['usuario_id']) && $_POST['usuario_id'] != '') {
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

        echo "estoy creando un usuario";

        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];

        $sql = "INSERT INTO usuario(nombre, email, rol)
        VALUES ('$nombre', '$email', '$rol')";

        $resultado = $conn->execute_query($sql);

        header("Location: index.php");
        exit;
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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($datosUsuario) ? 'Editar usuario' : 'Nuevo usuario'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-body-tertiary">
    <nav class="navbar bg-primary shadow-sm" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="index.php">Gestión de usuarios</a>
        </div>
    </nav>

    <main class="container py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <a class="link-secondary text-decoration-none d-inline-block mb-3" href="index.php">← Volver al listado</a>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="h3 mb-2"><?= isset($datosUsuario) ? 'Editar usuario' : 'Nuevo usuario'; ?></h1>
                        <p class="text-body-secondary mb-4">
                            <?= isset($datosUsuario) ? 'Modificá los datos del usuario seleccionado.' : 'Ingresá los datos para registrar un usuario.'; ?>
                        </p>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label" for="nombre">Nombre</label>
                                <input class="form-control" id="nombre" type="text" name="nombre"
                                    value="<?= htmlspecialchars($datosUsuario['nombre'] ?? ''); ?>" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="email">Correo electrónico</label>
                                <input class="form-control" id="email" type="email" name="email"
                                    value="<?= htmlspecialchars($datosUsuario['email'] ?? ''); ?>" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="rol">Rol</label>
                                <input class="form-control" id="rol" type="text" name="rol"
                                    value="<?= htmlspecialchars($datosUsuario['rol'] ?? ''); ?>" required>
                            </div>

                            <?php if (isset($datosUsuario['usuario_id'])): ?>
                                <input type="hidden" name="usuario_id"
                                    value="<?= htmlspecialchars($datosUsuario['usuario_id']); ?>">
                            <?php endif; ?>

                            <div class="d-flex flex-column-reverse flex-sm-row justify-content-end gap-2">
                                <a class="btn btn-outline-secondary" href="index.php">Cancelar</a>
                                <button class="btn btn-primary" type="submit">
                                    <?= isset($datosUsuario) ? 'Guardar cambios' : 'Crear usuario'; ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>
