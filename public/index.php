<?php

use MVC\Router;

require_once __DIR__ . '/../includes/app.php';

$router = new Router();

$router->get("/", []);

// Valida y comprueba las rutas
$router->comprobarRutas();
