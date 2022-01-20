<div class="panel-content contenedor">
    <div class="d-flex flex-beetwen">
        <h1 class="titulo titulo-content">Categorias</h1>
        <button class="btn btn-success" data-bs-toggle="modal" id="btn-register" data-bs-target="#modalCategoria">
            <i class="fas fa-plus"></i> Agregar
        </button>
    </div>

    <table class="table w-100" id="table_id">
        <thead class="table-dark">
            <tr>
                <th>Categoria</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<?php
$script = '<script src="/build/js/categoria.fetch.js"></script>';
?>

<div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: #000;" id="title">Registrar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario">
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" class="form-control" placeholder="tu nombre">
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