<?php

namespace Controllers;

use Model\Categoria;
use MVC\Router;

class CategoriaController
{
    public static function index(Router $router)
    {
        $router->viewDashboard('dashboard/categoria', []);
    }

    public static function creates()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $categoria = new Categoria($_POST);

            $verificar = $categoria->where('nombre', $categoria->nombre);

            if ($verificar) {
                echo json_encode(['res' => true, 'mensaje' => 'El nombre de la categoria ya existe']);
            } else {
                $categoria->guardar();
                echo json_encode(['res' => false, 'mensaje' => 'Se guardo correctamente la categoria']);
            }
        }
    }

    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $categoria = Categoria::find($_POST['id']);
            $categoria->sincronizar($_POST);

            $resultado = $categoria->guardar();

            echo json_encode(["res" => $resultado]);
        }
    }

    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $categoria = new Categoria($_POST);
            $resultado = $categoria->eliminar();
            echo json_encode([
                "res" => $resultado
            ]);
        }
    }

    public static function getCategorias()
    {
        echo json_encode(['data' => Categoria::all()]);
    }

    public static function getCategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            $categoria = Categoria::find($id);

            echo json_encode(['data' => $categoria]);
        }
    }
}
