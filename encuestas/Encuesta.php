<?php

class Encuesta
{
    private string $titulo;
    private string $descripcion;
    private string $estado;
    private string $categoria;
    private $listaPreguntas = array();
    private string $id;

    public function __construct(string $titulo, string $descripcion, string $categoria)
    {
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
        $this->estado = "borrador";
        $this->id = bin2hex(random_bytes(16));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function crearPregunta()
    {
        $pregunta = new Pregunta("titulo pregunta", "texto pregunta");
        array_push($this->listaPreguntas, $pregunta);
    }

    public function getTituloYDescripcion()
    {
        return $this->titulo . " Desc: " . $this->descripcion . " Cat: " . $this->categoria;
    }

    public function setTitulo(string $nuevoTitulo)
    {
        $this->titulo = $nuevoTitulo;
    }

    public function agregarPregunta(Pregunta $pregunta)
    {
        array_push($this->listaPreguntas, $pregunta);
    }

    public function getListaPreguntas()
    {
        return $this->listaPreguntas;
    }

    public function getPregunta(string $id): ?Pregunta
    {
        foreach ($this->listaPreguntas as $pregunta) {
            if ($pregunta->id == $id) {
                return $pregunta;
            }
        }
        return null;
    }
}
