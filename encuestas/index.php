<?php

require_once("./Encuesta.php");
require_once("./Pregunta.php");

$encuesta1 = new Encuesta("Servicio de Tomografia", "Este es el servicio de tomografia", "Tomografia");
$pregunta1 = new Pregunta("Pregunta 1", "Esta satisfecho con el servicio si o no?");
$pregunta1Opcion1 = new Opcion();
$pregunta1->setOpcion($pregunta1Opcion1);
$pregunta2 = new Pregunta("Pregunta 2", "En serio?");
$pregunta2Opcion1 = new Opcion();
$pregunta1->setOpcion($pregunta2Opcion1);
$pregunta3 = new Pregunta("Pregunta 3", "Seguro?");
$pregunta3Opcion1 = new Opcion();
$pregunta1->setOpcion($pregunta3Opcion1);
$pregunta4 = new Pregunta("Pregunta 4", "Volveria a pesar de todo?");
$pregunta4Opcion1 = new Opcion();
$pregunta1->setOpcion($pregunta4Opcion1);
$encuesta1->agregarPregunta($pregunta1);
$encuesta1->agregarPregunta($pregunta2);
$encuesta1->agregarPregunta($pregunta3);
$encuesta1->agregarPregunta($pregunta4);

$tamanoListaPreguntas = sizeof($encuesta1->getListaPreguntas());
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuestas</title>
</head>

<body>
    <h1>Encuestas</h1>

    <p>
        <?= $encuesta1->getTituloYDescripcion(); ?>
    </p>

    <p>Cuantas preguntas hay en la lista de preguntas de la encuesta 1</p>
    <p><?= $tamanoListaPreguntas; ?></p>

    <form method="POST">
        <?php foreach ($encuesta1->getListaPreguntas() as $pregunta): ?>

            <fieldset>
                <legend><?= $pregunta->getPregunta() ?></legend>

                <p><?= $pregunta->getTexto() ?></p>

                <label><input type="radio" name="novedades" value="si" required> Sí</label>
                <label><input type="radio" name="novedades" value="no"> No</label>
            </fieldset>

            <hr>
        <?php endforeach; ?>
    </form>

</body>

</html>