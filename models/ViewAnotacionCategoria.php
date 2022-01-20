<?php

namespace Model;

class ViewAnotacionCategoria extends ActiveRecord
{
    protected static $tabla = "anotacion";
    protected static $columnasDB = ['id', 'categoria', 'precio', 'estado', 'observacion'];

    public $id;
    public $categoria;
    public $precio;
    public $estado;
    public $observacion;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->categoria = $args['categoria'] ?? '';
        $this->precio = $args['precio'] ?? 0;
        $this->estado = $args['estado'] ?? '';
        $this->observacion = $args['observacion'] ?? '';
    }
}
