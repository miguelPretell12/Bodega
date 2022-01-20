<?php

namespace Model;

class ViewCategoriaSede extends ActiveRecord
{
    protected static $columnasDB = ['id', 'sede', 'direccion', 'empresa', 'categoria', 'estado'];

    public $id;
    public $sede;
    public $direccion;
    public $empresa;
    public $categoria;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->sede = $args['sede'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->empresa = $args['empresa'] ?? '';
        $this->categoria = $args['categoria'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }
}
