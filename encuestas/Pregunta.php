<?php

class Pregunta
{
    private string $pregunta;
    private string $texto;
    private string $obligatoria;
    private string $tipo;
    private Opcion $opcion;
    private string $id;

    public function __construct(string $pregunta, string $texto)
    {
        $this->pregunta = $pregunta;
        $this->texto = $texto;
        $this->id = bin2hex(random_bytes(16));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPregunta()
    {
        return $this->pregunta;
    }

    public function getTexto()
    {
        return $this->texto;
    }

    public function setOpcion(Opcion $opcion)
    {
        $this->opcion = $opcion;
    }

    public function getOpcion()
    {
        return $this->opcion;
    }
}
