<?php

namespace Model;

class Capital extends ActiveRecord
{
    protected static $tabla = 'capital';
    protected static $columnasDB = ['id', 'precio', 'idUsuario', 'idSede', 'fecha'];

    public $id;
    public $idUsuario;
    public $idSede;
    public $precio;
    public $fecha;

    public function __construct($args = [])
    {
        date_default_timezone_set("America/Lima");
        $this->id = $args['id'] ?? null;
        $this->idUsuario = $args['idUsuario'] ?? '';
        $this->idSede = $args['idSede'] ?? '';
        $this->precio = $args['precio'] ?? 0;
        $this->fecha = $args['fecha'] ?? date("Y-m-d");
    }
}
