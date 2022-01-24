<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="stylesheet" href="/build/css/bootstrap.min.css">
    <link rel="stylesheet" href="/build/css/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="/build/css/datatables/datatables.min.css">

    <script src="/build/js/jquery.min.js"></script>
    <script src="/build/js/datatables.min.js"></script>
</head>

<body>
    <div class="grid-dashboard">
        <div class="nav-dashboard">
            <div class="logo">
                <h2 class="titulo">Ventas</h2>
            </div>
            <ul class="nav-enlance">
                <?php if ($_SESSION['cargo'] == 'administrador') : ?>
                    <li><a href="/dashboard">Dashboard</a></li>
                    <li><a href="/dashboard/usuarios">Usuarios</a></li>
                    <li><a href="/dashboard/categorias">Categorias</a></li>
                    <li><a href="/dashboard/sedes">Sedes</a></li>
                    <li><a href="/dashboard/asignatCategoria">Asignar categorias a Sedes</a></li>
                    <li><a href="/dashboard/cargos">Cargos</a></li>
                    <li><a href="/dashboard/capital">Capital</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['cargo'] == 'supervisor') : ?>
                    <li><a href="/supervisor">Inicio</a></li>
                    <li><a href="/supervisor/capital">Capital</a></li>
                <?php endif; ?>

                <?php if ($_SESSION['cargo'] == 'empleado') : ?>
                    <li>Empleado</li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="content-dashboard">
            <div class="header-dashboard">
                <div class="head-content">
                    <a href="/<?php echo $_SESSION['cargo'] ?>/config"><i class=" fas fa-cog"></i></a>
                    <a href="/<?php echo $_SESSION['cargo'] ?>/info"><i class="fas fa-info-circle"></i></a>
                    <a href="/<?php echo $_SESSION['cargo'] ?>/cerrar"><i class="fas fa-door-open"></i></a>
                </div>
                <div class="info-content">
                    <div class="info">
                        <div class="info-text">
                            <p><?php echo $_SESSION['nombre'] ?> </p>
                            <span>Role: <small><?php echo $_SESSION['cargo'] ?></small></span>
                        </div>
                        <img src="/build/img/img1.jpg " alt="" class="img-info">
                    </div>
                </div>
            </div>

            <?php echo $contenido ?>

        </div>
        <div id="spinner" class="spinner-body">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src="/build/js/bootstrap.bundle.min.js"></script>
    <?php
    echo $script ?? '';
    ?>
</body>

</html>