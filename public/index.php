<?php

use Controllers\AdminController;
use Controllers\AsignarCategoriaController;
use Controllers\CapitalController;
use Controllers\CargosController;
use Controllers\CategoriaController;
use Controllers\EmpleadoController;
use Controllers\LoginController;
use Controllers\SedeController;
use Controllers\SupervisorController;
use Controllers\UsuariosController;
use MVC\Router;

require_once __DIR__ . '/../includes/app.php';

$router = new Router();

$router->get("/", [LoginController::class, 'login']);
$router->post("/login/iniciar", [LoginController::class, 'iniciar']);
$router->get("/login/recuperar", [LoginController::class, 'verificar']);


// Dashboard
$router->get('/dashboard', [AdminController::class, 'index']);
$router->get("/administrador/cerrar", [AdminController::class, 'cerrar']);
// Cargos
$router->get('/dashboard/cargos', [CargosController::class, 'index']);
$router->get('/dashboard/cargos/lists', [CargosController::class, 'lists']);
$router->post('/dashboard/cargos/getCargo', [CargosController::class, 'getCargo']);
$router->post('/dashboard/cargos/create', [CargosController::class, 'create']);
$router->post('/dashboard/cargos/update', [CargosController::class, 'update']);
$router->post('/dashboard/cargos/delete', [CargosController::class, 'delete']);


// Usuarios
$router->get('/dashboard/usuarios', [UsuariosController::class, 'index']);
$router->get('/dashboard/usuarios/getUsuarios', [UsuariosController::class, 'getUsuarios']);
$router->post('/dashboard/usuarios/create', [UsuariosController::class, 'create']);
$router->post("/dashboard/usuarios/getUsuario", [UsuariosController::class, 'getUsuario']);
$router->post('/dashboard/usuarios/update', [UsuariosController::class, 'update']);
$router->post('/dashboard/usuarios/delete', [UsuariosController::class, 'delete']);

// Categoria
$router->get('/dashboard/categorias', [CategoriaController::class, 'index']);
$router->get('/dashboard/categorias/getCategorias', [CategoriaController::class, 'getCategorias']);
$router->post('/dashboard/categorias/create', [CategoriaController::class, 'creates']);
$router->post('/dashboard/categorias/update', [CategoriaController::class, 'update']);
$router->post('/dashboard/categorias/delete', [CategoriaController::class, 'delete']);
$router->post('/dashboard/categorias/getCategoria', [CategoriaController::class, 'getCategoria']);

// Sedes
$router->get('/dashboard/sedes', [SedeController::class, 'index']);
$router->get('/dashboard/sedes/getSedes', [SedeController::class, 'getSedes']);
$router->post('/dashboard/sedes/getSede', [SedeController::class, 'getSede']);
$router->post('/dashboard/sedes/create', [SedeController::class, 'create']);
$router->post('/dashboard/sedes/update', [SedeController::class, 'update']);
$router->post('/dashboard/sedes/delete', [SedeController::class, 'delete']);
$router->get("/dashboard/sedes/getSupervisor", [SedeController::class, 'getSupervisor']);

//asignatCategoria
$router->get("/dashboard/asignarCategoria", [AsignarCategoriaController::class, 'index']);
$router->get("/dashboard/asignarCategoria/getAsignarCats", [AsignarCategoriaController::class, 'getAsignarCats']);

$router->post("/dashboard/asignarCategoria/create", [AsignarCategoriaController::class, 'create']);
$router->post("/dashboard/asignarCategoria/updateStatus", [AsignarCategoriaController::class, 'updateStatus']);

// Capital 
$router->get("/dashboard/capital", [CapitalController::class, 'index']);

// Supervisor
// index
$router->get("/supervisor", [SupervisorController::class, 'index']);
$router->get("/supervisor/capital", [SupervisorController::class, 'capital']);
$router->get("/supervisor/sedeSupervisor", [SupervisorController::class, 'sedeAuth']);
$router->get("/supervisor/listaEmpleados", [SupervisorController::class, 'listaEmpleados']);
$router->get("/supervisor/capitalAuth", [SupervisorController::class, 'capitalAuth']);
$router->post("/supervisor/capitales", [SupervisorController::class, 'capitales']);
$router->get("/supervisor/viewCapital", [SupervisorController::class, 'viewCapital']);
$router->get("/supervisor/getCategorias", [SupervisorController::class, 'getCategorias']);
$router->get("/supervisor/viewCapitalXCategoria", [SupervisorController::class, 'viewCapitalXCategoria']);
$router->get("/supervisor/getAnotaciones", [SupervisorController::class, 'getAnotaciones']);
$router->get("/supervisor/cerrar", [SupervisorController::class, 'cerrar']);

$router->post("/supervisor/createCapital", [SupervisorController::class, 'createCapital']);
$router->post("/supervisor/asignacionEmpleado", [SupervisorController::class, 'asignacionEmpleado']);
$router->post("/supervisor/getCapital", [SupervisorController::class, 'getCapital']);
$router->post("/supervisor/updateCapital", [SupervisorController::class, 'updateCapital']);
$router->post("/supervisor/createAnotacion", [SupervisorController::class, 'createAnotacion']);
$router->post("/supervisor/getAnotacion", [SupervisorController::class, 'getAnotacion']);
$router->post("/supervisor/updateAnotacion", [SupervisorController::class, 'updateAnotacion']);
$router->post("/supervisor/deleteAnotacion", [SupervisorController::class, 'deleteAnotacion']);

// Empleado
$router->get("/empleado", [EmpleadoController::class, 'index']);
$router->get("/empleado/cerrar", [EmpleadoController::class, 'cerrar']);
$router->get("/empleado/viewCapitals", [EmpleadoController::class, 'viewCapitals']);
$router->get("/empleado/viewCapital", [EmpleadoController::class, 'viewCapital']);
$router->get("/empleado/getCapitales", [EmpleadoController::class, 'getCapitales']);
$router->get("/empleado/getCategorias", [EmpleadoController::class, 'getCategorias']);
$router->get("/empleado/getCapitalE", [EmpleadoController::class, 'getCapitalE']);
$router->get("/empleado/getViewCategorias", [EmpleadoController::class, 'getViewCategorias']);
$router->get("/empleado/getSedeXEmpleado", [EmpleadoController::class, 'getSedeXEmpleado']);

$router->post("/empleado/getCapital", [EmpleadoController::class, 'getCapital']);
$router->post("/empleado/updateCapital", [EmpleadoController::class, 'updateCapital']);
$router->post("/empleado/createAnotacion", [EmpleadoController::class, 'createAnotacion']);
$router->post("/empleado/createCapital", [EmpleadoController::class, 'createCapital']);
// Valida y comprueba las rutas
$router->comprobarRutas();
