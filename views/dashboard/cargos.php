<div class="panel-content contenedor">
    <div class="d-flex flex-beetwen">
        <h1 class="titulo titulo-content">Cargos</h1>
        <button class="btn btn-success" id="btn" data-bs-toggle="modal" data-bs-target="#modalCargo">
            <i class="fas fa-plus"></i> Agregar
        </button>
    </div>

    <table class="table w-100" id="table_id">
        <thead class="table-dark">
            <tr>
                <th>Cargo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<?php
$script = '<script src ="/build/js/cargos.fetch.js"></script>';
?>


<div class="modal fade" id="modalCargo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: #000;" id="staticBackdropLabel">Registrar Cargo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario">
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <label for="">Cargo</label>
                        <input type="text" id="nombre" class="form-control">
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