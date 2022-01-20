<?php

namespace Controllers;

use MVC\Router;

class CapitalController
{
    public static function index(Router $router)
    {
        $router->viewDashboard("dashboard/capital", []);
    }

    public static function create()
    {
    }

    public static function update()
    {
    }

    public static function delete()
    {
    }

    public static function getCapitales()
    {
    }

    public static function getCapital()
    {
    }
}
