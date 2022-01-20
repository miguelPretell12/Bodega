<?php

namespace Controllers;

use MVC\Router;

class AdminController
{
    public static function index(Router $router)
    {
        $router->viewDashboard('dashboard/index', []);
    }
}
