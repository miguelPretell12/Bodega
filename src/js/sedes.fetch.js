$(document).ready(function () {
  tableAll();
  formulario();
  obtenerData();
  eliminarSede();
  getSupervisor();
});

$(document).on("click", "#btn", function () {
  clean();
});

function clean() {
  $("#id").val("");
  $("#nombre").val("");
  $("#direccion").val("");
  $("#empresa").val("");
}

function tableAll() {
  $("#table_id").DataTable({
    destroy: true,
    ajax: {
      method: "GET",
      url: "/dashboard/sedes/getSedes",
    },
    columns: [
      { data: "sede" },
      { data: "empresa" },
      { data: "direccion" },
      { data: "supervisornombre" },
      {
        data: null,
        render: function (data, type, row) {
          return `
            <button class="btn btn-warning far fa-edit" data-idsede="${data.id}" id="edit" data-bs-toggle="modal" data-bs-target="#modalSede" ></button>
            <button class="btn btn-danger far fa-trash-alt" data-idsede="${data.id}" id="delete"></button>
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
    const direccion = $("#direccion").val();
    const empresa = $("#empresa").val();
    const supervisor = $("#supervisor").val();

    // Form Data
    const data = new FormData();
    data.append("nombre", nombre.toLowerCase());
    data.append("direccion", direccion.toLowerCase());
    data.append("empresa", empresa.toLowerCase());
    data.append("idSupervisor", supervisor);

    if (nombre == "" || direccion == "" || empresa == "" || supervisor == "") {
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
    const id = e.target.dataset.idsede;
    const data = new FormData();
    data.append("id", id);
    getSede(data);
  });
}
function eliminarSede() {
  $(document).on("click", "#delete", function (e) {
    const id = e.target.dataset.idsede;
    const data = new FormData();

    Swal.fire({
      title: "¿ Usted quiere eliminar este usuario ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, deseo eliminar el usuario",
    }).then((result) => {
      if (result.isConfirmed) {
        data.append("id", id);
        remove(data);
      }
    });
  });
}

async function create(data) {
  const url = " /dashboard/sedes/create";
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
    $("#modalSede").modal("hide");
    tableAll();
  }
}
async function update(data) {
  const url = " /dashboard/sedes/update";
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });
  const resultado = await respuesta.json();

  const { resp } = resultado;
  if (resp) {
    Swal.fire("Exito!", "Se edito correctamente la sede", "success");
    $("#modalSede").modal("hide");
    tableAll();
  }
}
async function getSede(datas) {
  const url = " /dashboard/sedes/getSede";
  const respuesta = await fetch(url, {
    method: "POST",
    body: datas,
  });
  const resultado = await respuesta.json();
  //   console.log(resultado.data.id);

  const { data } = resultado;

  $("#id").val(data.id);
  $("#nombre").val(data.nombre);
  $("#direccion").val(data.direccion);
  $("#empresa").val(data.empresa);
}
async function remove(data) {
  const url = " /dashboard/sedes/delete";
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });
  const resultado = await respuesta.json();

  const { resp } = resultado;

  if (resp) {
    Swal.fire("Exito!", "Se elimino de manera efectiva la sede", "success");
    tableAll();
  } else {
    Swal.fire(
      "Error!",
      "Error al eliminar la sede, puede que ya ha sido registrado en otros registros",
      "error"
    );
  }
}

async function getSupervisor() {
  const url = "/dashboard/sedes/getSupervisor";
  const respuesta = await fetch(url);

  const resultado = await respuesta.json();

  const { data } = resultado;

  const supervisor = document.querySelector("#supervisor");
  data.forEach((d) => {
    const option = document.createElement("option");
    const { id, nombre, dni, correo, cargo, estado } = d;
    if (estado == "A") {
      option.value = id;
      option.innerHTML = `${nombre}`;
      supervisor.appendChild(option);
    }
  });
  console.log(data);
}
