<?php

namespace Model;

class CategoriaSede extends ActiveRecord
{
    protected static $tabla = 'categoriaSede';
    protected static $columnasDB = ['id', 'idSede', 'idCategoria', 'estado'];

    public $id;
    public $idSede;
    public $idCategoria;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idSede = $args['idSede'] ?? '';
        $this->idCategoria = $args['idCategoria'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }
}
