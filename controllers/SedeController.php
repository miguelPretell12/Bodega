<?php

namespace Controllers;

use Model\Sedes;
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
        echo json_encode(['data' => Sedes::all()]);
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
}
