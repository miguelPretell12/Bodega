<?php

namespace Model;

class ViewCapital extends ActiveRecord
{
    protected static $columnasDB = ['id', 'capital', 'fecha', 'sede', ' direccion', 'empresa'];

    public $id;
    public $capital;
    public $fecha;
    public $sede;
    public $direccion;
    public $empresa;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->capital = $args['capital'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->sede = $args['sede'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->empresa = $args['empresa'] ?? '';
    }
}
