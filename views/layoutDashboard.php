<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="/build/css/style.css">
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
    <div class="contenedor-dashboard">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="logo-apple"></ion-icon>
                        </span>
                        <span class="title">Brand Name</span>
                    </a>
                </li>
                <li>
                    <a href="/">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <?php if ($_SESSION['cargo'] == 'administrador') : ?>
                    <li>
                        <a href="/dashboard/usuarios">
                            <span class="icon">
                                <ion-icon name="people-outline"></ion-icon>
                            </span>
                            <span class="title">Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/categorias">
                            <span class="icon">
                                <ion-icon name="people-outline"></ion-icon>
                            </span>
                            <span class="title">categorias</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/sedes">
                            <span class="icon">
                                <ion-icon name="people-outline"></ion-icon>
                            </span>
                            <span class="title">sedes</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/asignarCategoria">
                            <span class="icon">
                                <ion-icon name="people-outline"></ion-icon>
                            </span>
                            <span class="title">Asignar categorias a Sedes</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/cargos">
                            <span class="icon">
                                <ion-icon name="people-outline"></ion-icon>
                            </span>
                            <span class="title">cargos</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/capital">
                            <span class="icon">
                                <ion-icon name="people-outline"></ion-icon>
                            </span>
                            <span class="title">capital</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="/<?php echo $_SESSION['cargo'] ?>/cerrar">
                        <span class="icon">
                            <ion-icon name="close-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Cerrar</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- main -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
                <div class="user">
                    <img src="images/user.jpg" alt="">
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

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src="/build/js/dashboard.js"></script>
    <script src="/build/js/bootstrap.bundle.min.js"></script>
    <?php
    echo $script ?? '';
    ?>
</body>

</html>