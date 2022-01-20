<?php

namespace Model;

use Model\Cargos;

class Usuarios extends ActiveRecord
{
    protected static $tabla = "usuarios";
    protected static $columnasDB = [
        'id', 'nombre', 'apellido', 'dni',
        'correo', 'password', 'idCargo', 'token', 'estado', 'idSupervisor', 'idSede'
    ];

    public $id;
    public $nombre;
    public $apellido;
    public $dni;
    public $correo;
    public $password;
    public $idCargo;
    public $token;
    public $estado;
    public $idSupervisor;
    public $idSede;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->dni = $args['dni'] ?? '';
        $this->correo = $args['correo'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->idCargo = $args['idCargo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->idSupervisor = $args['idSupervisor'] ?? '';
        $this->idSede = $args['idSede'] ?? '';
    }

    public function verificar()
    {

        $resultado = Usuarios::where('correo', $this->correo);
        if ($resultado) {
            $verificarPassword = password_verify($this->password, $resultado->password);
            $cargo = Cargos::find($resultado->idCargo);
            if ($verificarPassword) {
                $_SESSION['id'] = $resultado->id;
                $_SESSION['nombre'] = $resultado->nombre . ' ' . $resultado->apellido;
                $_SESSION['cargo'] = $cargo->nombre;
                $_SESSION['estado'] = $resultado->estado;
                echo json_encode([
                    "cargo" => $cargo->nombre,
                    "estado" => $resultado->estado,
                    "bool" => true
                ]);
            } else {
                echo json_encode([
                    "bool" => false,
                    "mensaje" => "Password escrito incorrectamente"
                ]);
            }
        } else {
            echo json_encode([
                "bool" => false,
                "mensaje" => "Correo mal escrito o no registrado"
            ]);
        }
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
}
