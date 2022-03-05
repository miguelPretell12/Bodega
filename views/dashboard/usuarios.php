<div class="panel-content contenedor">
    <div class="d-flex flex-beetwen">
        <h1 class="titulo titulo-content">Usuarios</h1>
        <button class="btn btn-success" data-bs-toggle="modal" id="btn-register" data-bs-target="#modalUsuario">
            <i class="fas fa-plus"></i> Agregar
        </button>
    </div>

    <table class="table w-100" id="table_id">
        <thead class="table-dark">
            <tr>
                <th>Nombre y Apellido</th>
                <th>Correo Electronico</th>
                <th>D.N.I</th>
                <th>Cargo</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<?php
$script = '<script src ="/build/js/usuarios.fetch.js"></script>';
?>


<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: #000;" id="title">Registrar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario">
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" class="form-control" placeholder="tu nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" id="apellido" class="form-control" placeholder="tu apellido">
                    </div>
                    <div class="form-group">
                        <label for="dni">D.N.I.</label>
                        <input type="text" id="dni" class="form-control" placeholder="tu dni">
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" class="form-control" placeholder="tu correo">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" class="form-control" placeholder="tu contraseña">
                    </div>
                    <div class="form-group">
                        <label for="cargo">Cargo</label>
                        <select id="cargo" class="form-control">
                            <option value="">-- Seleccione --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="supervisor">Supervisor</label>
                        <select id="supervisor" class="form-control">
                            <option value="">-- Seleccione --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">estado</label>
                        <select id="estado" class="form-control">
                            <option value="">-- Seleccione --</option>
                            <option value="A">ACTIVO</option>
                            <option value="I">INACTIVO</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>