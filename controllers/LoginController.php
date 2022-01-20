<?php

namespace Controllers;

use Model\Usuarios;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        $router->render('login/index', []);
    }

    public static function iniciar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuarios = new Usuarios($_POST);
            $usuarios->verificar();
        }
    }
}
