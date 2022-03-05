$(document).ready(function (e) {
  getCategorias();
  viewCapitalXCategoria();
  formulario();
  tableAll();
  obtenerData();
  eliminarAnotacion();
});

$(document).on("click", "#btn-anotacion", function (e) {
  clean();
});

function tableAll() {
  const getId = window.location.search;

  const params = new URLSearchParams(getId);
  const id = params.get("id");
  $("#table_id").DataTable({
    destroy: true,
    ajax: {
      method: "GET",
      url: `/supervisor/getAnotaciones?id=${id}`,
    },
    columns: [
      { data: "categoria" },
      { data: "precio" },
      { data: "estado" },
      { data: "observacion" },
      {
        data: null,
        render: function (data, type, row) {
          return `
            <button class="btn btn-warning far fa-edit" data-idanotacion="${data.id}" id="edit" data-bs-toggle="modal" data-bs-target="#modalAnotacion" ></button>
            <button class="btn btn-danger far fa-trash-alt" data-idanotacion="${data.id}" id="delete"></button>
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
    const categoria = $("#categoria").val();
    const precio = $("#precio").val();
    const capital = $("#capital").val();
    const observacion = $("#observacion").val();

    const data = new FormData();
    data.append("precio", precio);
    data.append("idCapital", capital);
    data.append("idCategoria", categoria);
    data.append("estado", "pendiente");
    data.append("observacion", observacion);

    if (id == "") {
      create(data);
    } else {
      data.append("id", id);
      update(data);
    }
  });
}

function spinnerHide(res) {
  document.querySelector("#spinner").style.display = res;
}

function obtenerData() {
  $(document).on("click", "#edit", function (e) {
    clean();
    const id = e.target.dataset.idanotacion;
    const data = new FormData();
    data.append("id", id);
    getAnotacion(data);
  });
}

function eliminarAnotacion() {
  $(document).on("click", "#delete", function (e) {
    const id = e.target.dataset.idanotacion;

    const data = new FormData();
    data.append("id", id);
    // remove(data);
    Swal.fire({
      title: "¿ Usted quiere eliminar esta anotación ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, deseo eliminar la anotacion",
    }).then((result) => {
      if (result.isConfirmed) {
        remove(data);
        tableAll();
      }
    });
  });
}

async function getAnotacion(data) {
  const url = " /supervisor/getAnotacion";
  spinnerHide("flex");
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });

  if (respuesta) {
    spinnerHide("none");
  }

  const resultado = await respuesta.json();

  const { id, precio, idCategoria, idCapital, observacion } = resultado.res;
  $("#categoria").val(idCategoria);
  $("#precio").val(precio);
  $("#capital").val(idCapital);
  $("#observacion").val(observacion);
  $("#id").val(id);
}

async function getCategorias() {
  const getId = window.location.search;

  const params = new URLSearchParams(getId);
  const id = params.get("id");
  const url = ` /supervisor/getCategorias?id=${id}`;
  const respuesta = await fetch(url);
  const resultado = await respuesta.json();

  const select = document.querySelector("#categoria");

  const { data } = resultado;
  data.forEach((d) => {
    const option = document.createElement("option");
    option.value = d.id;
    option.textContent = d.nombre;

    select.appendChild(option);
  });
}

async function viewCapitalXCategoria() {
  const getId = window.location.search;

  const params = new URLSearchParams(getId);
  const id = params.get("id");

  const url = ` /supervisor/viewCapitalXCategoria?id=${id}`;
  const respuesta = await fetch(url);

  const resultado = await respuesta.json();
  console.log(resultado);

  const { data } = resultado;

  const select = document.querySelector("#capital");
  data.forEach((d) => {
    const option = document.createElement("option");
    option.value = d.id;
    option.textContent = `${d.capital} - Sede:${d.sede}`;
    select.appendChild(option);
  });
}

async function create(data) {
  const url = " /supervisor/createAnotacion";
  spinnerHide("flex");
  const respuesta = await fetch(url, { method: "POST", body: data });
  if (respuesta) {
    spinnerHide("none");
  }
  const resultado = await respuesta.json();

  if (resultado.res) {
    Swal.fire("Exito!", "Se guardo correctamente la anotacion", "success");
    tableAll();
    "#modalAnotacion".modal("hide");
  } else {
    Swal.fire("Error!", "Error al guardar", "error");
  }
}

async function update(data) {
  const url = " /supervisor/updateAnotacion";
  spinnerHide("flex");
  const respuesta = await fetch(url, { method: "POST", body: data });
  if (respuesta) {
    spinnerHide("none");
  }
  const resultado = await respuesta.json();

  if (resultado.res) {
    Swal.fire("Exito!", "Se edito correctamente la anotacion", "success");
    tableAll();
    $("#modalAnotacion").modal("hide");
  } else {
    Swal.fire("Error!", "Error al guardar", "error");
  }
}

async function remove(data) {
  const url = " /supervisor/deleteAnotacion";
  spinnerHide("flex");
  const respuesta = await fetch(url, { method: "POST", body: data });
  if (respuesta) {
    spinnerHide("none");
  }
  const resultado = await respuesta.json();

  if (resultado.res) {
    Swal.fire("Exito!", "Se elimino correctamente la anotacion", "success");
    tableAll();
  } else {
    Swal.fire("Error!", "Error al eliminar", "error");
  }
}

function clean() {
  $("#categoria").val("");
  $("#precio").val("");
  $("#observacion").val("");
  $("#id").val("");
}
