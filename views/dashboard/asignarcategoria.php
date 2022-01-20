<div class="panel-content contenedor">
    <div class="d-flex flex-beetwen">
        <h1>Asignar</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAsignCat">Agregar</button>
    </div>
    <table class="table w-100" id="table_id">
        <thead class="table-dark">
            <tr>
                <th>Sede</th>
                <th>Dirección</th>
                <th>Categoria</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="modal fade" id="modalAsignCat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: #000;" id="staticBackdropLabel">Registrar Sedes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario">
                    <input type="hidden" id="id">
                    <div class="form-group mb-2">
                        <label for="sede">Sede</label>
                        <select id="sede" class="form-control">
                            <option value="">-- SELECCIONE --</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="categoria">Categoria</label>
                        <select id="categoria" class="form-control">
                            <option value="">-- SELECCIONE --</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="estado">Estado</label>
                        <select id="estado" class="form-control">
                            <option value="">-- SELECCIONE --</option>
                            <option value="H">Habilitado</option>
                            <option value="I">Inhabilitado</option>
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

<?php
$script = '<script src="/build/js/asigCat.fetch.js"></script>';
?>