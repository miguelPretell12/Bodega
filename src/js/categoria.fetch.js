$(document).ready(function (e) {
  tableAll();
  formulario();
  obtenerData();
  eliminar();
});

$(document).on("click", "#btn-register", function () {
  clean();
});

function tableAll() {
  $("#table_id").DataTable({
    destroy: true,
    ajax: {
      method: "GET",
      url: "/dashboard/categorias/getCategorias",
    },
    columns: [
      { data: "nombre" },
      {
        data: null,
        render: function (data, type, row) {
          return `
            <button class="btn btn-warning far fa-edit" data-idcategoria="${data.id}" id="edit" data-bs-toggle="modal" data-bs-target="#modalCategoria" ></button>
            <button class="btn btn-danger far fa-trash-alt" data-idcategoria="${data.id}" id="delete"></button>
          `;
        },
      },
    ],
  });
}
function formulario() {
  $(document).on("submit", "#formulario", function (e) {
    e.preventDefault();
    const id = $("#id").val();
    const nombre = $("#nombre").val();

    const data = new FormData();
    data.append("nombre", nombre.toLowerCase());
    if (nombre == "") {
      Swal.fire({
        position: "top-end",
        icon: "error",
        title: "Completar los campos requeridos",
        showConfirmButton: false,
        timer: 1500,
      });
    } else {
      if (id == "") {
        create(data);
      } else {
        data.append("id", id);
        update(data);
      }
    }
  });
}

function obtenerData() {
  $(document).on("click", "#edit", function (e) {
    const id = e.target.dataset.idcategoria;
    const data = new FormData();
    data.append("id", id);
    getCategoria(data);
  });
}

function eliminar() {
  $(document).on("click", "#delete", function (e) {
    const idcategoria = e.target.dataset.idcategoria;
    const data = new FormData();
    data.append("id", idcategoria);
    Swal.fire({
      title: "¿ Usted quiere eliminar este usuario ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, deseo eliminar el usuario",
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

// Funciones asincronas
async function create(data) {
  const url = " /dashboard/categorias/create";
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });
  const resultado = await respuesta.json();

  const { res, mensaje } = resultado;
  if (res) {
    Swal.fire("Error!", mensaje, "error");
  } else {
    Swal.fire("Exito!", mensaje, "success");
    $("#modalCategoria").modal("hide");
    tableAll();
  }
}
async function update(data) {
  const url = " /dashboard/categorias/update";
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });
  const resultado = await respuesta.json();

  const { res } = resultado;

  if (res) {
    Swal.fire("Exito!", "Se edito correctamente la categoria", "success");
    $("#modalCategoria").modal("hide");
    tableAll();
  } else {
    Swal.fire("Error!", "Hubo un error al editar la categoria", "error");
  }
}
async function remove(data) {
  const url = " /dashboard/categorias/delete";
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });
  const resultado = await respuesta.json();
  const { res } = resultado;

  if (res) {
    Swal.fire(
      "Eliminado!",
      "La categoria ha sido eliminado correctamente",
      "success"
    );
  } else {
    Swal.fire("Error!", "No se pudo eliminar la categoria", "error");
  }
}
async function getCategoria(data) {
  const url = " /dashboard/categorias/getCategoria";
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });
  const resultado = await respuesta.json();
  const { id, nombre } = resultado.data;

  $("#id").val(id);
  $("#nombre").val(nombre);
}
