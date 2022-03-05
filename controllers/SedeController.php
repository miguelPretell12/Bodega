<?php

namespace Controllers;

use Model\Sedes;
use Model\UsuarioCargo;
use Model\Usuarios;
use Model\ViewSedeSupervisor;
use MVC\Router;

class SedeController
{
    public static function index(Router $router)
    {
        $router->viewDashboard('dashboard/sedes', []);
    }

    public static function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sede = new Sedes($_POST);

            $verificarSede = $sede::where('nombre', $sede->nombre);
            if ($verificarSede) {
                echo json_encode([
                    "resp" => true,
                    "mensaje" => 'La sede ya ha sido registrada'
                ]);
            } else {
                $sede->guardar();
                echo json_encode([
                    "resp" => false,
                    "mensaje" => "Se guardo la sede, exitosamente"
                ]);
            }
        }
    }

    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            $sede = Sedes::find($id);

            $sede->sincronizar($_POST);
            $resultado = $sede->guardar();
            echo json_encode([
                "resp" => $resultado
            ]);
        }
    }

    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sede = new Sedes($_POST);
            $resultado = $sede->eliminar();

            echo json_encode(["resp" => $resultado]);
        }
    }

    public static function getSedes()
    {
        $sedesupervisor = "
            SELECT 
                s.id as id,
                s.nombre as sede,
                s.direccion as direccion,
                s.empresa as empresa,
                concat(u.nombre,' ',u.apellido) as supervisornombre,
                c.nombre as cargo
            FROM sedes s
            inner join usuarios u on u.id = s.idSupervisor
            inner join cargos c on c.id = u.idCargo 
        ";
        $resultado = ViewSedeSupervisor::SQL($sedesupervisor);
        echo json_encode(['data' => $resultado]);
    }

    public static function getSede()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            $sede = Sedes::find($id);

            echo json_encode(["data" => $sede]);
        }
    }

    public static function getSupervisor()
    {
        $usuariocargo = "SELECT 
            u.id as id,
            concat(u.nombre,' ',u.apellido) as nombre,
            u.dni as dni,
            u.correo as correo,
            c.nombre as cargo,
            u.estado as estado
         FROM usuarios u
         inner join cargos c on c.id = u.idCargo where c.nombre = 'supervisor'";
        $resultado = UsuarioCargo::SQL($usuariocargo);
        echo json_encode(['data' => $resultado]);
    }
}
