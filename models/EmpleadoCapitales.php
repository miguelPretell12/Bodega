<?php

namespace Model;

class EmpleadoCapitales extends ActiveRecord
{
    protected static $tabla = '';
    protected static $columnasDB = [
        'id', 'idCapital',
        'sede', 'idSede', 'empresa', 'capital', 'fecha'
    ];

    public $id;
    public $idCapital;
    public $sede;
    public $idSede;
    public $empresa;
    public $capital;
    public $fecha;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idCapital = $args['idCapital'] ?? '';
        $this->sede = $args['sede'] ?? '';
        $this->idSede = $args['idSede'] ?? '';
        $this->empresa = $args['empresa'] ?? '';
        $this->capital = $args['capital'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
    }
}
