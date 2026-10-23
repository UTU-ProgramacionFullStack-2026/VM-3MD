<?php

class Opcion
{
    private string $id;
    private bool $respuesta;
    private string $tipo = "binaria";

    public function __construct()
    {
        $this->id = bin2hex(random_bytes(16));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setRespuesta(string $respuesta)
    {
        if ($respuesta == "si") {
            $this->respuesta = true;
        } else {
            $this->respuesta = false;
        }
    }

    public function getRespuesta()
    {
        return $this->respuesta;
    }
}
