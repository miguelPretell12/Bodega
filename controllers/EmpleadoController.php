<?php

namespace Controllers;

use Model\Anotacion;
use Model\Capital;
use Model\CapitalSede;
use Model\Categoria;
use Model\empleadoCapital;
use Model\EmpleadoCapitales;
use Model\Sedes;
use Model\Usuarios;
use Model\ViewAnotacionCategoria;
use Model\ViewCapital;
use MVC\Router;

class EmpleadoController
{
    public static function index(Router $router)
    {
        isEmpleado();

        $router->viewDashboard("empleado/index", []);
    }

    public static function cerrar()
    {

        $_SESSION = [];
        header("location: /");
    }

    public static function viewCapitals(Router $router)
    {
        isEmpleado();
        $router->viewDashboard("empleado/capital", []);
    }

    public static function getCapitales()
    {
        isEmpleado();
        $contenido = "SELECT 
            ec.id as id,
            c.id as idCapital,
            s.nombre as sede,
            s.empresa as empresa,
            c.precio as capital,
            c.fecha as fecha
        FROM empleadocapital ec
        inner join capital c on c.id = ec.idCapital
        INNER JOIN usuarios u on u.id = ec.idUsuario
        inner join sedes s on s.id = c.idSede
        WHERE ec.idUsuario = " . $_SESSION['id'];
        $resultado = EmpleadoCapitales::SQL($contenido);
        echo json_encode([
            "data" => $resultado
        ]);
    }

    public static function getCapital()
    {
        isEmpleado();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // $capital = Capital::find($_POST['id']);
            $contenido =
                "SELECT 
                ec.id as id,
                c.id as idCapital,
                s.nombre as sede,
                s.id as idSede,
                s.empresa as empresa,
                c.precio as capital,
                c.fecha as fecha
            FROM empleadocapital ec
            inner join capital c on c.id = ec.idCapital
            INNER JOIN usuarios u on u.id = ec.idUsuario
            inner join sedes s on s.id = c.idSede
            WHERE ec.idUsuario = " . $_SESSION['id'] . " and ec.idCapital = " . $_POST['id'];

            $capital = EmpleadoCapitales::SQL($contenido);
            echo json_encode([
                "data" => $capital
            ]);
        }
    }

    public static function updateCapital()
    {
        isEmpleado();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $capital = Capital::find($_POST['id']);
            $capital->sincronizar($_POST);

            echo json_encode([
                "res" => $capital->guardar()
            ]);
        }
    }

    public static function viewCapital(Router $router)
    {
        isEmpleado();
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        $contenido = "SELECT 
            c.id as id,
            c.precio as capital,
            c.fecha as fecha,
            s.nombre as sede,
            s.direccion as direccion,
            s.empresa as empresa
        from empleadocapital ec 
        inner join capital c on c.id = ec.idCapital
        inner join usuarios u on ec.idUsuario = u.id
        inner join sedes s on s.id = c.idSede
        where ec.idCapital = " . $id;

        $resultado = ViewCapital::SQL($contenido);

        $router->viewDashboard("empleado/viewCapital", [
            "capital" => $resultado
        ]);
    }

    public static function getViewCategorias()
    {
        isEmpleado();
        $contenido = "SELECT 
            ca.nombre as categoria,
            a.precio as precio,
            a.estado as estado,
            a.observacion as observacion
        FROM empleadocapital ec 
        inner join capital c on c.id = ec.idCapital
        inner join anotacion a on a.idCapital = c.id
        inner join categorias ca on ca.id = a.idCategoria
        where ec.idCapital = 9 and ec.idUsuario=3";
        $resultado = ViewAnotacionCategoria::SQL($contenido);

        echo json_encode([
            "data" => $resultado
        ]);
    }

    public static function getCategorias()
    {
        isEmpleado();
        $contenido = "select 
                ct.nombre as nombre,
                ct.id as id
            from empleadocapital ec 
            inner join capital c on c.id = ec.idCapital
            inner join sedes s on s.id = c.idSede
            inner join categoriasede cs on cs.idSede = s.id
            inner join categorias ct on ct.id = cs.idCategoria
            where ec.idCapital =" . $_GET['id'] . " and cs.estado = 'H'";
        $resultado = Categoria::SQL($contenido);
        echo json_encode([
            "categoria" => $resultado
        ]);
    }

    public static function getCapitalE()
    {
        isEmpleado();
        $contenido = "
            select 
                c.id as id,
                s.nombre as sede,
                c.precio as capital,
                c.fecha as fecha
            from capital c 
            inner join sedes s on s.id = c.idSede
            where c.id = " . $_GET['capital'];
        $resultado = CapitalSede::SQL($contenido);

        echo json_encode([
            "cap" => $resultado
        ]);
    }

    public static function createAnotacion()
    {
        isEmpleado();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $anotacion = new Anotacion($_POST);

            echo json_encode([
                "resp" => $anotacion->guardar()
            ]);
        }
    }

    //obtenerSedeXEmpleado
    public static function getSedeXEmpleado()
    {
        isEmpleado();
        $empleado = Usuarios::where('id', $_SESSION['id']);
        $sede = Sedes::where("idUsuario", $empleado->idSupervisor);
        echo json_encode([
            "data" => $sede
        ]);
    }

    // Create capital
    public static function createCapital()
    {
        isEmpleado();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            date_default_timezone_set("America/Lima");
            $fechaExistente = Capital::where('fecha', date("Y-m-d"));

            if (!$fechaExistente) {
                $capitalEmpleado = new Capital($_POST);

                // obtener el id del supervisor
                $empleado = Usuarios::where('id', $_SESSION['id']);

                $capitalEmpleado->idUsuario = $empleado->idSupervisor;

                $res = $capitalEmpleado->guardar();

                $args = [
                    "idUsuario" => $_SESSION['id'],
                    "idCapital" => $res['id']
                ];

                $empleadoCapital = new empleadoCapital($args);
                $resp = $empleadoCapital->guardar();
                echo json_encode([
                    "res" => true,
                    "mensaje" => "Registro exitoso",
                    "s" => $fechaExistente
                ]);
            } else {
                echo json_encode([
                    "res" => false,
                    "mensaje" => "Capital ya ha sido registrada "
                ]);
            }
        }
    }
}
