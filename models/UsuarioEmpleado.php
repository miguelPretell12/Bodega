<?php

namespace Model;

class UsuarioEmpleado extends ActiveRecord
{
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['id', 'empleado', 'cargo', 'dni'];

    public $id;
    public $empleado;
    public $cargo;
    public $dni;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->empleado = $args['empleado'] ?? '';
        $this->cargo = $args['cargo'] ?? '';
        $this->dni = $args['dni'] ?? '';
    }
}
