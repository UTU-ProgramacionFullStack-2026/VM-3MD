<?php

require_once('db.php');
$sql = "SELECT * FROM usuario";
$resultado = $conn->execute_query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de usuarios</title>
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
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
            <div>
                <h1 class="h2 mb-1">Usuarios</h1>
                <p class="text-body-secondary mb-0">Administrá los usuarios registrados en el sistema.</p>
            </div>
            <a class="btn btn-primary" href="crearEditarUsuario.php">+ Nuevo usuario</a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Nombre</th>
                            <th scope="col">Correo electrónico</th>
                            <th scope="col">Rol</th>
                            <th scope="col" class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultado->num_rows === 0): ?>
                            <tr>
                                <td colspan="4" class="text-center text-body-secondary py-5">
                                    Todavía no hay usuarios registrados.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($resultado as $fila): ?>
                                <tr>
                                    <td class="fw-medium ps-4"><?= htmlspecialchars($fila['nombre']); ?></td>
                                    <td><?= htmlspecialchars($fila['email']); ?></td>
                                    <td><span class="badge text-bg-secondary"><?= htmlspecialchars($fila['rol']); ?></span></td>
                                    <td class="text-end pe-4 text-nowrap">
                                        <a class="btn btn-sm btn-outline-primary"
                                            href="crearEditarUsuario.php?id=<?= urlencode($fila['usuario_id']); ?>">Editar</a>
                                        <a class="btn btn-sm btn-outline-danger"
                                            href="borrar.php?id=<?= urlencode($fila['usuario_id']); ?>"
                                            onclick="return confirm('¿Seguro que querés borrar este usuario?');">Borrar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>
