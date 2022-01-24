<div class="panel-content contenedor">
    <div class="d-flex flex-beetwen">
        <a href="/empleado/viewCapitals" class="btn btn-success">
            Volver
        </a>
    </div>
    <?php
    foreach ($capital as $res) :
    ?>

        <div class="d-flex flex-beetwen">
            <div>
                <h1 class="title-vc"><?php echo $res->sede ?> <span>(<?php echo $res->empresa ?>)</span></span></h1>
                <p class="direccion-vc">Dirección: <span><?php echo $res->direccion ?></span></p>
            </div>
            <div>
                <p class="fecha-vc">Fecha: <span><?php echo $res->fecha ?></span></p>
            </div>
        </div>
        <hr>
        <div class="capital-vc">
            Capital: <span><?php echo $res->capital ?></span>
        </div>
    <?php endforeach; ?>

    <div class="panel-content">
        <div class="d-flex flex-beetwen">
            <h2>Anotaciones</h1>
                <div>
                    <button class="btn btn-primary" id="btn-anotacion" data-bs-toggle="modal" data-bs-target="#modalAnotacion">Crear Anotacion</button>
                </div>
        </div>
        <table class="table w-100" id="table_anotacion">
            <thead class="table-dark">
                <tr>
                    <th>Categoria</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Observacion</th>
                </tr>
            </thead>
            <tbody class="w-100"></tbody>
        </table>
    </div>
</div>

<?php
$script = "<script src='/build/js/empleado/empleado.fetch.js'></script>";
?>


<div class="modal fade" id="modalAnotacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color:black">Asignacion de capital a empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formularioA">
                    <input type="hidden" id="id">
                    <div class="form-group mb-1">
                        <label for="categoria">Categoria</label>
                        <select id="categoria" class="form-control">
                            <option value="">-- SELECCIONE --</option>
                        </select>
                    </div>
                    <div class="form-group mb-1">
                        <label for="">Precio</label>
                        <input type="number" id="precio" class="form-control" step="0.01">
                    </div>
                    <div class="form-group mb-1">
                        <label for="capital">Capital</label>
                        <select id="capital" class="form-control" disabled></select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="observacion">Observacion</label>
                        <textarea id="observacion" cols="20" rows="3" class="form-control"></textarea>
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