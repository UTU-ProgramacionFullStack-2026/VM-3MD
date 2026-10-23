<?php

require_once("./Encuesta.php");
require_once("./Pregunta.php");
require_once("./Opcion.php");

$encuesta1 = new Encuesta("Servicio de Tomografia", "Este es el servicio de tomografia", "Tomografia");
$pregunta1 = new Pregunta("Pregunta 1", "Esta satisfecho con el servicio si o no?");
$pregunta1Opcion1 = new Opcion();
$pregunta1->setOpcion($pregunta1Opcion1);
$pregunta2 = new Pregunta("Pregunta 2", "En serio?");
$pregunta2Opcion1 = new Opcion();
$pregunta2->setOpcion($pregunta2Opcion1);
$pregunta3 = new Pregunta("Pregunta 3", "Seguro?");
$pregunta3Opcion1 = new Opcion();
$pregunta3->setOpcion($pregunta3Opcion1);
$pregunta4 = new Pregunta("Pregunta 4", "Volveria a pesar de todo?");
$pregunta4Opcion1 = new Opcion();
$pregunta4->setOpcion($pregunta4Opcion1);

$encuesta1->agregarPregunta($pregunta1);
$encuesta1->agregarPregunta($pregunta2);
$encuesta1->agregarPregunta($pregunta3);
$encuesta1->agregarPregunta($pregunta4);
