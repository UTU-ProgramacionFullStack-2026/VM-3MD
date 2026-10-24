<?php

require_once("conexion.php");
require_once("SistemaEncuestas.php");

$sistema = new SistemaEncuestas($conexion);
$sistema->cargarEncuestas();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Encuestas del hospital</title>
</head>

<body>
    <h1>Encuestas del hospital</h1>

    <ul>
        <?php foreach ($sistema->getEncuestas() as $encuesta): ?>
            <li>
                <?= $encuesta->getTitulo() ?>
                - <a href="responder.php?id=<?= $encuesta->getId() ?>">Responder</a>
                - <a href="resultados.php?id=<?= $encuesta->getId() ?>">Resultados</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <p><a href="crear.php">Nueva encuesta</a></p>
</body>

</html>
