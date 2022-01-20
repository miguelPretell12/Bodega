<?php

namespace Model;

class UsuarioCargo extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'dni', 'correo', 'cargo', 'estado'];

    public $id;
    public $nombre;
    public $dni;
    public $correo;
    public $cargo;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->dni = $args['dni'] ?? null;
        $this->correo = $args['correo'] ?? null;
        $this->cargo = $args['cargo'] ?? null;
        $this->estado = $args['estado'] ?? null;
    }
}
