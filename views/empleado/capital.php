<div class="panel-content contenedor">
    <div class="d-flex flex-beetwen mb-2">
        <a href="/empleado" class="btn btn-success">
            Volver
        </a>
    </div>
</div>

<div class="panel-content contenedor">
    <div class="d-flex flex-beetwen">
        <h2 class="titulo titulo-content"> Capital </h2>
        <button class="btn btn-primary" id="btn-capital" data-bs-toggle="modal" data-bs-target="#modalCapital">Agregar Capital</button>
    </div>
    <table class="table w-100" id="table_id">
        <thead class="table-dark">
            <tr>
                <th>Capital</th>
                <th>Sede</th>
                <th>Fecha</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalCapital" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color:black">Capital</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario">
                    <input type="hidden" id="id">
                    <div class="form-group mb-1">
                        <label for="">Capital</label>
                        <input type="number" id="capital" step="0.01" class="form-control">
                    </div>
                    <div class="form-group mb-1">
                        <label for="">Sede</label>
                        <select id="sede" class="form-control" disabled>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$script = "<script src='/build/js/empleado/empleado.fetch.js'></script>";
?>