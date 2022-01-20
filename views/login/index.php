<div class="flex-column body">
    <div class="login">
        <div class="imagen-logo">
            <img src="/build/img/contabilidad.png" alt="">
        </div>

        <form id="formulario">
            <div class="input-form">
                <i class="far fa-envelope"></i>
                <input type="email" id="correo" placeholder="Tu email">
            </div>
            <div class="input-form">
                <i class="fas fa-key"></i>
                <input type="password" id="password" placeholder="Tu password">
            </div>
            <button type="submit" class="btn btn-success text-right w-100 mt-1 text-uppercase">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesion
            </button>
        </form>

        <div class="opciones">
            <a href="/recuperar"><span>¿Olvidaste tu contraseña?.</span>Haz click aqui</a>
        </div>
    </div>
</div>
<?php
$script = '<script src="build/js/login.js"></script>';
?>