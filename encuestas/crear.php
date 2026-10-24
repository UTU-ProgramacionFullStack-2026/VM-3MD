<?php

require_once("conexion.php");
require_once("SistemaEncuestas.php");

$sistema = new SistemaEncuestas($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Primero armamos los objetos con lo que llegó del formulario...
    $encuesta = new Encuesta(null, $_POST['titulo'], $_POST['descripcion']);

    foreach ($_POST['preguntas'] as $datosPregunta) {
        $respuesta = $sistema->crearRespuesta($datosPregunta['tipo']);
        $pregunta = new Pregunta(null, $datosPregunta['texto'], $respuesta);
        $encuesta->agregarPregunta($pregunta);
    }

    // ...y después el sistema los guarda en la base
    $sistema->guardarEncuesta($encuesta);

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nueva encuesta</title>
</head>

<body>
    <h1>Nueva encuesta</h1>

    <form method="POST">
        <p>
            <label>Título</label><br>
            <input type="text" name="titulo" required>
        </p>

        <p>
            <label>Descripción</label><br>
            <textarea name="descripcion"></textarea>
        </p>

        <!-- Acá el JavaScript va agregando las preguntas -->
        <div id="preguntas"></div>

        <p>
            <button type="button" onclick="agregarPregunta()">Nueva pregunta</button>
        </p>

        <input type="submit" value="Guardar encuesta">
    </form>

    <p><a href="index.php">Volver</a></p>

    <script src="crear.js"></script>
</body>

</html>
