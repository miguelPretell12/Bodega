<?php

namespace Controllers;

use Model\CategoriaSede;
use Model\ViewCategoriaSede;
use MVC\Router;

class AsignarCategoriaController
{
    public static function index(Router $router)
    {
        $router->viewDashboard("dashboard/asignarcategoria", []);
    }

    public static function getAsignarCats()
    {
        $contenido = 'SELECT 
            cs.id as id,
            s.nombre as sede,
            s.direccion as direccion,
            s.empresa as empresa,
            c.nombre as categoria,
            cs.estado as estado
        FROM categoriasede cs
        INNER JOIN sedes s on s.id = cs.idSede
        INNER JOIN categorias c on c.id = cs.idCategoria';
        $data = ViewCategoriaSede::SQL($contenido);

        echo json_encode(["data" => $data]);
    }

    public static function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $catesede = new CategoriaSede($_POST);

            $contenido = "
                SELECT * FROM categoriaSede
                where idSede =" . $catesede->idSede . " and 
                idCategoria = " . $catesede->idCategoria . "";
            $resultado = CategoriaSede::SQL($contenido);
            if ($resultado) {
                echo json_encode(["mensaje" => "La asignacion de la categoria a la sede ya esta registrada", "res" => true]);
            } else {
                $catesede->guardar();
                echo json_encode(["mensaje" => "Se registro la asignacion con exito", "res" => false]);
            }
        }
    }

    public static function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            $asigcat = CategoriaSede::find($id);
            $asigcat->sincronizar($_POST);
            if ($asigcat->estado == 'H') {
                $asigcat->estado = 'I';
            } else if ($asigcat->estado == 'I') {
                $asigcat->estado = 'H';
            }

            $resultado = $asigcat->actualizar();

            echo json_encode([
                "res" => $resultado
            ]);
        }
    }
}
