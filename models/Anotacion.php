<?php

namespace Model;

class Anotacion extends ActiveRecord
{
    protected static $tabla = 'anotacion';
    protected static $columnasDB =
    ['id', 'precio', 'idCategoria', 'idCapital', 'estado', 'observacion'];

    public $id;
    public $precio;
    public $idCategoria;
    public $idCapital;
    public $estado;
    public $observacion;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->precio = $args['precio'] ?? 0.0;
        $this->idCategoria = $args['idCategoria'] ?? '';
        $this->idCapital = $args['idCapital'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->observacion = $args['observacion'] ?? '';
    }
}
