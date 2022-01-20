<?php

namespace Model;

class empleadoCapital extends ActiveRecord
{
    protected static $tabla = 'empleadoCapital';
    protected static $columnasDB = ['id', 'idUsuario', 'idCapital'];

    public $id;
    public $idUsuario;
    public $idCapital;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idUsuario = $args['idUsuario'] ?? '';
        $this->idCapital = $args['idCapital'] ?? '';
    }
}
