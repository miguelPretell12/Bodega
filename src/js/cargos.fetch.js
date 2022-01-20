// const formulario = document.querySelector("#formulario");
$(document).ready(function () {
  formulario();
  tableAll();
  obtenerData();
  deleteCargo();
});

$(document).on("click", "#btn", function () {
  clean();
});

async function create(data) {
  const url = `http://localhost:4000/dashboard/cargos/create`;
  const resp = await fetch(url, {
    method: "POST",
    body: data,
  });

  const resultado = await resp.json();

  const { res, bool } = resultado;
  if (bool) {
    Swal.fire({
      icon: "success",
      title: "Exito",
      text: res,
    });
    $("#modalUsuario").modal("hide");
  } else {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: res,
    });
  }
}

function formulario() {
  $("#formulario").on("submit", function (e) {
    e.preventDefault();
    const nombre = document.querySelector("#nombre").value;
    const id = document.querySelector("#id").value;

    const data = new FormData();
    data.append("nombre", nombre.toLowerCase());

    if (id == "") {
      create(data);
    } else {
      data.append("id", id);
      update(data);
    }

    tableAll();
    clean();
  });
}

function tableAll() {
  $("#table_id").DataTable({
    destroy: true,
    ajax: {
      method: "GET",
      url: "/dashboard/cargos/lists",
    },
    columns: [
      { data: "nombre" },
      {
        data: null,
        render: function (data, type, row) {
          return `
            <button class="btn btn-warning far fa-edit" data-idcargo="${data.id}" id="edit" data-bs-toggle="modal" data-bs-target="#modalCargo" ></button>
          <button class="btn btn-danger far fa-trash-alt" data-idcargo="${data.id}" id="delete"></button>
          `;
        },
      },
    ],
  });
}

function obtenerData() {
  // #edit
  $(document).on("click", "#edit", function (e) {
    // const idCargo = e.target.dataset.idcargo;
    const icono = e.target.dataset.idcargo;
    const data = new FormData();
    data.append("id", icono);
    getCargo(data);
  });
}

function deleteCargo() {
  $(document).on("click", "#delete", function (e) {
    const idCargo = e.target.dataset.idcargo;

    const data = new FormData();
    data.append("id", idCargo);
    // remove(data);
    Swal.fire({
      title: "¿ Usted quiere eliminar este cargo ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, deseo eliminar el cargo",
    }).then((result) => {
      if (result.isConfirmed) {
        remove(data);
        tableAll();
      }
    });
  });
}

function clean() {
  $("#id").val("");
  $("#nombre").val("");
}

async function getCargo(data) {
  const url = "http://localhost:4000/dashboard/cargos/getCargo";
  const resp = await fetch(url, {
    method: "POST",
    body: data,
  });
  const resultado = await resp.json();
  const { id, nombre } = resultado.data;
  // Contenido
  $("#id").val(id);
  $("#nombre").val(nombre);
}

async function update(data) {
  const url = "http://localhost:4000/dashboard/cargos/update";
  const resp = await fetch(url, {
    method: "POST",
    body: data,
  });

  const res = await resp.json();

  if (res.res) {
    $("#modalUsuario").modal("hide");
  }
}

async function remove(data) {
  const url = "http://localhost:4000/dashboard/cargos/delete";

  const resp = await fetch(url, {
    method: "POST",
    body: data,
  });

  const resultado = await resp.json();

  const { res } = resultado;
  if (res) {
    Swal.fire(
      "Eliminado!",
      "El cargo ha sido eliminado correctamente",
      "success"
    );
  } else {
    Swal.fire(
      "Error!",
      "El cargo no ha sido eliminado correctamente o este cargo ha sido registrado en otro registro",
      "error"
    );
  }
}
