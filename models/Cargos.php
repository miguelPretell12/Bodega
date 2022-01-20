<?php

namespace Model;

class Cargos extends ActiveRecord
{
    protected static $tabla = 'cargos';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }
}
