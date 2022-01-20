<?php

namespace Controllers;

use Model\Cargos;
use MVC\Router;

class CargosController
{
    public static function index(Router $router)
    {
        $router->viewDashboard('dashboard/cargos', []);
    }

    public static function lists()
    {
        echo json_encode([
            "data" => Cargos::all()
        ]);
    }

    public static function getCargo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            $data = Cargos::find($id);
        }
        echo json_encode([
            "data" => $data
        ]);
    }

    public static function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cargo = new Cargos($_POST);
            $verificarNombre = Cargos::where('nombre', $cargo->nombre);

            if ($verificarNombre) {
                $res = 'Cargo ya registrado, cree otro cargo';
                $boolean = false;
            } else {
                $resultado = $cargo->guardar();
                $res = 'Se registro correctamente ';
                $boolean = true;
            }

            echo json_encode([
                "res" => $res,
                "bool" => $boolean,
                "prueba" => $resultado
            ]);
        }
    }

    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            $cargo = Cargos::find($id);

            $cargo->sincronizar($_POST);

            $resultado = $cargo->guardar();

            echo json_encode([
                "res" => $resultado
            ]);
        }
    }

    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cargo = new Cargos($_POST);
            $resultado = $cargo->eliminar();

            echo json_encode([
                "res" => $resultado
            ]);
        }
    }
}
