$(document).ready(function () {
  tableAll();
  tableViewCapital();
  obtenerData();
  formulario();
  formularioAn();
  getCategorias();
  getCapital();
  getSedeXEmpleado();
});

$(document).on("click", "#btn-capital", function (e) {
  cleanCapital();
});

function tableAll() {
  $("#table_id").DataTable({
    destroy: true,
    ajax: {
      method: "GET",
      url: "/empleado/getCapitales",
    },
    columns: [
      {
        data: "capital",
      },
      {
        data: null,
        render: function (data, type, row) {
          return `${data.sede} (${data.empresa})`;
        },
      },
      {
        data: "fecha",
      },
      {
        data: null,
        render: function (data, type, row) {
          const fecha = new Date();
          const day = fecha.getDate();
          const month = fecha.getMonth() + 1;
          const monthIf = month <= 9 ? 0 + month : month;
          const year = fecha.getFullYear();
          const fechActual = `${year}-0${monthIf}-${day}`;
          return `
                <button class="btn btn-warning far fa-edit"
                style = "display: ${
                  fechActual != data.fecha ? "none" : "inline-block"
                } "
                data-idcapital="${
                  data.idCapital
                }" id="edit" data-bs-toggle="modal" data-bs-target="#modalCapital">
                </button>
                <a class="btn btn-success far fa-eye" href="/empleado/viewCapital?id=${
                  data.idCapital
                }"></a>
            `;
        },
      },
    ],
  });
}

function tableViewCapital() {
  $("#table_anotacion").DataTable({
    destroy: true,
    ajax: {
      method: "GET",
      url: "/empleado/getViewCategorias",
    },
    columns: [
      {
        data: "categoria",
      },
      {
        data: "precio",
      },
      {
        data: "estado",
      },
      {
        data: "observacion",
      },
    ],
  });
}

function obtenerData() {
  $(document).on("click", "#edit", function (e) {
    const idcapitale = e.target.dataset.idcapital;

    const data = new FormData();
    data.append("id", idcapitale);

    getCapitalEmpleado(data);
  });
}

function formulario() {
  $(document).on("submit", "#formulario", function (e) {
    e.preventDefault();
    const idcapital = $("#id").val();
    const precio = $("#capital").val();
    const sede = $("#sede").val();

    const data = new FormData();
    data.append("precio", precio);
    data.append("idSede", sede);

    if (idcapital == "") {
      createCapital(data);
    } else {
      data.append("id", idcapital);
      update(data);
    }
  });
}

function formularioAn() {
  $(document).on("submit", "#formularioA", function (e) {
    e.preventDefault();
    const categoria = $("#categoria").val();
    const precio = $("#precio").val();
    const capital = $("#capital").val();
    const observacion = $("#observacion").val();

    const data = new FormData();
    data.append("idCategoria", categoria);
    data.append("precio", precio);
    data.append("idCapital", capital);
    data.append("observacion", observacion);
    data.append("estado", "pendiente");

    createAnotacion(data);
  });
}

//Funciones asyncronas
async function getCapitalEmpleado(datas) {
  const url = "http://localhost:4000/empleado/getCapital";
  spinnerHide("flex");
  const respuesta = await fetch(url, {
    method: "POST",
    body: datas,
  });

  if (respuesta) {
    spinnerHide("none");
  }
  const resultado = await respuesta.json();

  const { data } = resultado;

  const select = document.querySelector("#sede");
  data.forEach((d) => {
    const { capital, sede, idSede, idCapital, empresa } = d;
    $("#id").val(idCapital);
    $("#capital").val(capital);

    const option = document.createElement("option");
    option.value = idSede;
    option.textContent = `${sede} (${empresa})`;
    select.appendChild(option);
  });
}

async function update(data) {
  const url = "http://localhost:4000/empleado/updateCapital";
  spinnerHide("flex");
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });

  if (respuesta) {
    spinnerHide("none");
  }

  const resultado = await respuesta.json();

  const { res } = resultado;
  if (res) {
    Swal.fire("Exito!!", "Se edito correctamente", "success");
    tableAll();
  } else {
    Swal.fire("Error!!", "Hubo un error al editar", "error");
  }
}

async function getCategorias() {
  const getId = window.location.search;

  const params = new URLSearchParams(getId);
  const id = params.get("id");
  const url = `http://localhost:4000/empleado/getCategorias?id=${id}`;
  const respuesta = await fetch(url);
  const resultado = await respuesta.json();

  const select = document.querySelector("#categoria");

  const { categoria } = resultado;

  categoria.forEach((cat) => {
    const { id, nombre } = cat;
    const option = document.createElement("option");
    option.value = id;
    option.textContent = nombre;

    select.appendChild(option);
  });
}

async function getCapital() {
  const getId = window.location.search;

  const params = new URLSearchParams(getId);
  const id = params.get("id");

  const url = `http://localhost:4000/empleado/getCapitalE?capital=${id}`;
  const respuesta = await fetch(url);
  const resultado = await respuesta.json();

  const select = document.querySelector("#capital");

  const { cap } = resultado;

  cap.forEach((c) => {
    const { id, sede, capital, fecha } = c;

    const option = document.createElement("option");
    option.value = id;
    option.textContent = `Capital: ${capital} - Sede: ${sede}`;
    select.appendChild(option);
  });
}

async function createAnotacion(data) {
  const url = "http://localhost:4000/empleado/createAnotacion";
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });

  const resultados = await respuesta.json();

  const { resultado } = resultados.resp;

  if (resultado) {
    Swal.fire("Exito!", "Se guardo exitosamente", "success");
    $("#modalAnotacion").modal("hide");
    tableViewCapital();
  } else {
    Swal.fire("Error!", "Error al guardar!", "error");
  }
}

async function getSedeXEmpleado() {
  const url = "http://localhost:4000/empleado/getSedeXEmpleado";

  const respuesta = await fetch(url);

  const resultado = await respuesta.json();

  const { data } = resultado;

  const select = document.querySelector("#sede");

  const { id, nombre, empresa, direccion } = data;
  const option = document.createElement("option");
  option.value = id;
  option.textContent = `${nombre} (${empresa})`;
  select.appendChild(option);
}
// spinner
function spinnerHide(res) {
  document.querySelector("#spinner").style.display = res;
}

async function createCapital(data) {
  const url = "http://localhost:4000/empleado/createCapital";
  spinnerHide("flex");
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });

  const resultado = await respuesta.json();

  if (respuesta) {
    spinnerHide("none");
  }
  const { res, mensaje } = resultado;

  if (res) {
    Swal.fire("Exito!!", mensaje, "success");
    tableAll();
    $("#modalCapital").modal("hide");
  } else {
    Swal.fire("Error!!", mensaje, "error");
  }
}

function cleanCapital() {
  $("#id").val("");
  $("#capital").val("");
}
