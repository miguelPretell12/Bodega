<?php

function isSupervisor()
{
    if ($_SESSION['cargo'] != 'supervisor' || empty($_SESSION)) {
        header("location: /");
    }
}

function isEmpleado()
{
    if ($_SESSION['cargo'] != 'empleado' || empty($_SESSION)) {
        header("location: /");
    }
}
