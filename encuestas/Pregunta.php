<?php

class Pregunta
{
    private $pregunta;
    private $texto;
    private $obligatoria;
    private $tipo;
    private $opcion;

    public function __construct(string $pregunta, string $texto)
    {
        $this->pregunta = $pregunta;
        $this->texto = $texto;
    }

    public function getPregunta()
    {
        return $this->pregunta;
    }

    public function getTexto()
    {
        return $this->texto;
    }

    public function setOpcion($opcion)
    {
        $this->opcion = $opcion;
    }

    public function getOpcion()
    {
        return $this->opcion;
    }
}
