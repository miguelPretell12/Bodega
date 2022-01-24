<?php

namespace Controllers;

use Model\Anotacion;
use Model\Capital;
use Model\CapitalSede;
use Model\Categoria;
use Model\empleadoCapital;
use Model\Sedes;
use Model\UsuarioEmpleado;
use Model\ViewAnotacionCategoria;
use Model\ViewCapital;
use MVC\Router;

class SupervisorController
{

    public static function index(Router $router)
    {
        isSupervisor();
        $contenido = "select
            u.id as id,
            concat(u.nombre,' ',u.apellido) as empleado,
            ce.nombre as cargo,
            u.dni as dni
        from usuarios u
        INNER JOIN usuarios s on s.id = u.idSupervisor
        INNER JOIN cargos c on c.id = s.idCargo
        inner join cargos ce on  ce.id = u.idCargo
        WHERE c.nombre = '" . $_SESSION['cargo'] . "' && u.idSupervisor =" . $_SESSION['id'] . "  ";

        $empleadoSupervisor = UsuarioEmpleado::SQL($contenido);


        $router->viewDashboard('supervisor/index', [
            "empleadoSupervisor" => $empleadoSupervisor
        ]);
    }

    public static function listaEmpleados()
    {
        isSupervisor();
        $contenido = "select
            u.id as id,
            concat(u.nombre,' ',u.apellido) as empleado,
            ce.nombre as cargo,
            u.dni as dni
        from usuarios u
        INNER JOIN usuarios s on s.id = u.idSupervisor
        INNER JOIN cargos c on c.id = s.idCargo
        inner join cargos ce on  ce.id = u.idCargo
        WHERE c.nombre = '" . $_SESSION['cargo'] . "' && u.idSupervisor =" . $_SESSION['id'] . "  ";

        $empleadoSupervisor = UsuarioEmpleado::SQL($contenido);

        echo json_encode([
            "dataEmpleado" => $empleadoSupervisor
        ]);
    }

    public static function sedeAuth()
    {
        isSupervisor();
        $id = $_SESSION['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        $contenido = "SELECT s.id as id, s.nombre as nombre, s.direccion as direccion, s.empresa as empresa FROM sedes s
            INNER JOIN usuarios sp on sp.id = s.idUsuario
            INNER JOIN cargos c on c.id = sp.idCargo
            where c.nombre ='" . $_SESSION['cargo'] . "'  and s.idUsuario = " . $id . "
        ";
        $resultado = Sedes::SQL($contenido);
        echo json_encode(['datas' => $resultado]);
    }

    public static function capitalAuth()
    {
        isSupervisor();
        date_default_timezone_set("America/Lima");
        $contenido = "SELECT 
            c.id as id,  
            s.nombre as sede,
            c.precio as capital,
            c.fecha as fecha
        FROM capital c 
        INNER JOIN sedes s on s.id = c.idSede
        where c.idUsuario = " . $_SESSION['id'] . " and c.fecha = '" . date("Y-m-d") . "'";
        $resultado = CapitalSede::SQL($contenido);

        echo json_encode([
            "data" => $resultado
        ]);
    }

    public static function capitales()
    {
        isSupervisor();
        $contenido = "SELECT 
            c.id as id,  
            s.nombre as sede,
            c.precio as capital,
            c.fecha as fecha
        FROM capital c 
        INNER JOIN sedes s on s.id = c.idSede
        where c.idUsuario = " . $_SESSION['id'];
        $resultado = CapitalSede::SQL($contenido);
        echo json_encode([
            "data" => $resultado
        ]);
    }

    public static function getCapital()
    {
        isSupervisor();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            $capital = Capital::find($id);
            echo json_encode([
                'capital' => $capital
            ]);
        }
    }

    public static function capital(Router $router)
    {
        isSupervisor();
        $router->viewDashboard("supervisor/capital", []);
    }

    public static function createCapital()
    {
        isSupervisor();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $capital = new Capital($_POST);
            $verificarFecha = Capital::where('fecha', date("Y-m-d"));
            $verificarSede = Capital::where('idSede', $capital->idSede);
            if ($verificarFecha && $verificarSede) {
                echo json_encode([
                    "res" => true,
                    "mensaje" => "La Capital solo se puede registrar uno por fecha y por sede"
                ]);
            } else {
                $capital->idUsuario = $_SESSION['cargo'] == 'administrador' || $_SESSION['cargo'] == 'supervisor' ? $_SESSION['id'] : '';
                $capital->crear();

                echo json_encode([
                    "res" => false,
                    "mensaje" => "Capital ya registrada"
                ]);
            }
        }
    }

    public static function updateCapital()
    {
        isSupervisor();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            $capital = Capital::find($id);

            $capital->sincronizar($_POST);

            $capital->guardar();

            echo json_encode([
                'res' => true
            ]);
        }
    }

    public static function asignacionEmpleado()
    {
        isSupervisor();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            date_default_timezone_set("America/Lima");
            $asigEmpl = new empleadoCapital($_POST);

            $verificarFecha = Capital::where('id', $asigEmpl->idCapital);

            $contenido = "
                SELECT 
                    ec.id as id,
                    ec.idUsuario as idUsuario,
                    ec.idCapital as idCapital
                FROM empleadoCapital ec 
                INNER JOIN capital c on c.id = ec.idCapital
                where ec.idUsuario =" . $asigEmpl->idUsuario . "  and c.fecha ='" . date("Y-m-d") . "'
            ";
            $verificarEmpleado = empleadoCapital::SQL($contenido);

            if ($verificarFecha->fecha !== date("Y-m-d") || $verificarEmpleado) {
                echo json_encode([
                    'res' => true,
                    "date" => date('Y-m-d h:i:s'),
                    "mensaje" => 'No se pudo registrar con exito, porque la capital no es de la fecha actual ' . date("Y-m-d") . ' o porque ya se registro al empleado en la capital seleccionada'
                ]);
            } else {
                $asigEmpl->guardar();
                echo json_encode([
                    'res' => false,
                    "rr" => $verificarEmpleado,
                    "mensaje" => 'Se pudo registrar con exito'
                ]);
            }
        }
    }

    // Mirar la capital y los apuntes como gastos, yapes, y prestamos (posiblemente esteen)
    public static function viewCapital(Router $router)
    {
        isSupervisor();
        $contenido = "
            SELECT 
                c.id as id,
                c.precio as capital,
                c.fecha as fecha,
                s.nombre as sede,
                s.direccion as direccion,
                s.empresa as empresa
            FROM capital c 
            INNER JOIN sedes s on s.id = c.idSede
            WHERE c.id = " . $_GET['id'] . "
            group by c.idSede
        ";
        $respuesta = ViewCapital::SQL($contenido);

        $router->viewDashboard("supervisor/viewCapital", [
            "respuesta" => $respuesta
        ]);
    }

    public static function viewCapitalXCategoria()
    {
        isSupervisor();
        $id = $_GET['id'] ?? null;
        $contenido = "SELECT 
                c.id as id,
                c.precio as capital,
                c.fecha as fecha,
                s.nombre as sede,
                s.direccion as direccion,
                s.empresa as empresa
        FROM capital c 
        INNER JOIN sedes s on s.id = c.idSede
        where c.id =" . $id . "";
        $respuesta = ViewCapital::SQL($contenido);
        echo json_encode([
            "data" => $respuesta
        ]);
    }

    public static function getCategorias()
    {
        isSupervisor();
        $contenido = "select 
        ct.id as id,
        ct.nombre as nombre
        from capital c 
        inner join sedes s on s.id = c.idSede
        inner join categoriasede cs on cs.idSede = s.id
        inner join categorias ct on ct.id = cs.idCategoria
        where c.id =" . $_GET['id'] . " and cs.estado = 'H'
        group by cs.idCategoria";
        $resultado = Categoria::SQL($contenido);
        echo json_encode([
            "data" => $resultado
        ]);
    }

    public static function createAnotacion()
    {
        isSupervisor();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $anotacion = new Anotacion($_POST);

            $resultado = $anotacion->guardar();

            echo json_encode([
                "res" => $resultado
            ]);
        }
    }
    public static function getAnotacion()
    {
        isSupervisor();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $anotacion = Anotacion::find($_POST['id']);

            echo json_encode([
                "res" => $anotacion
            ]);
        }
    }

    public static function updateAnotacion()
    {
        isSupervisor();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $anotacion = Anotacion::find($_POST['id']);
            $anotacion->sincronizar($_POST);

            echo json_encode([
                "res" => $anotacion->guardar()
            ]);
        }
    }

    public static function getAnotaciones()
    {
        isSupervisor();
        $contenido = "select
            a.id as id,
            ct.nombre as categoria,
            a.precio as precio,
            a.estado as estado,
            a.observacion as observacion
        from anotacion a 
        inner join categorias ct on ct.id = a.idCategoria
        inner join capital c on c.id = a.idCapital
        where a.idCapital =" . $_GET['id'] . "";

        $resultado = ViewAnotacionCategoria::SQL($contenido);
        echo json_encode([
            "data" => $resultado
        ]);
    }

    public static function deleteAnotacion()
    {
        isSupervisor();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $anotacion = new Anotacion($_POST);

            echo json_encode([
                "res" => $anotacion->eliminar()
            ]);
        }
    }

    public static function cerrar()
    {
        $_SESSION = [];
        header("Location: /");
    }
}
