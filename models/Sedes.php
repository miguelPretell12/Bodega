<?php

namespace Model;

class Sedes extends ActiveRecord
{
    protected static $tabla = 'sedes';
    protected static $columnasDB = ['id', 'nombre', 'direccion', 'empresa', 'idSupervisor'];

    public $id;
    public $nombre;
    public $direccion;
    public $empresa;
    public $idSupervisor;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->empresa = $args['empresa'] ?? '';
        $this->idSupervisor = $args['idSupervisor'] ?? '';
    }
}
