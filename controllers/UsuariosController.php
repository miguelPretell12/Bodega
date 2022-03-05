<?php

namespace Controllers;

use Model\UsuarioCargo;
use Model\Usuarios;
use MVC\Router;

class UsuariosController
{
    public static function  index(Router $router)
    {
        $router->viewDashboard('dashboard/usuarios', []);
    }

    public static function getUsuarios()
    {
        $contenido = "select
        u.id as id, concat(u.nombre,' ', u.apellido) as nombre, 
        u.dni as dni, u.correo as correo,
        c.nombre as cargo, u.estado as estado
        from usuarios u inner join cargos c on c.id = u.idCargo";

        $resultado = UsuarioCargo::SQL($contenido);
        echo  json_encode(['data' => $resultado]);
    }

    public static function getUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            $usuario = Usuarios::find($id);

            echo json_encode([
                'data' => $usuario
            ]);
        }
    }

    public static function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = new Usuarios($_POST);
            $usuario->hashPassword();

            $verificarCorreo = Usuarios::where("correo", $usuario->correo);

            if ($verificarCorreo) {
                $resultado = true;
                $mensaje = "El correo ya esta siendo utilizado";
            } else {
                $usuario->guardar();
                $resultado = false;
                $mensaje = "Su registro ha sido guardado con exito";
            }

            echo json_encode([
                "res" => $resultado,
                "mensaje" => $mensaje
            ]);
        }
    }

    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            $usuario = Usuarios::find($id);

            $usuario->sincronizar($_POST);
            // $usuario->hashPassword();

            $resultado = $usuario->guardar();
            echo json_encode([
                "res" => $resultado
            ]);
        }
    }

    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $usuario = new Usuarios($_POST);
            $resultado = $usuario->eliminar();

            echo json_encode([
                'res' => $resultado
            ]);
        }
    }
}
