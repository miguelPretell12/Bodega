<?php

namespace Model;

class ViewSedeSupervisor extends ActiveRecord
{
    protected static $columnasDB = ['id', 'sede', 'direccion', 'empresa', 'supervisornombre', 'cargo'];

    public $id;
    public $sede;
    public $direccion;
    public $empresa;
    public $supervisornombre;
    public $cargo;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->sede = $args['sede'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->empresa = $args['empresa'] ?? '';
        $this->supervisornombre = $args['supervisornombre'] ?? '';
        $this->cargo = $args['cargo'] ?? '';
    }
}
