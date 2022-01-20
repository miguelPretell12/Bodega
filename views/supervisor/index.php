<div class="panel-content contenedor">
    <h1>Supervisor: <span><?php echo $_SESSION['nombre'] ?></span></h1>
</div>

<div class="panel-content contenedor">
    <div class="flex-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Empleado encargados
        </button>
        <a href="/supervisor/capital" class="btn btn-warning">Ver Capital</a>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color:black">Empleados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <?php foreach ($empleadoSupervisor as $empleado) : ?>
                        <li class="list-group-item "><?php echo $empleado->empleado ?> - DNI: <span style="font-weight: BOLD;"> <?php echo $empleado->dni  ?> </span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
$script = '<script src="/build/js/supervisor/index.fetch.js"></script>';
?>