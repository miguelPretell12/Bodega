<?php

namespace Model;

class CapitalSede extends ActiveRecord
{
    protected static $tabla = 'capital';
    protected static $columnasDB = ['id', 'sede', 'capital', 'fecha'];

    public $id;
    public $sede;
    public $capital;
    public $fecha;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->sede = $args['sede'] ?? '';
        $this->capital = $args['capital'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
    }
}
