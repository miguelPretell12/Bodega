const body = document.querySelector("#spinner");
$(document).ready(function () {
  iniciarApp();
});

$(document).on("click", "#add-capital", function (e) {
  cleanCapital();
});

$(document).on("click", "#add-asignacion", function (e) {
  cleanAsignacion();
});

function iniciarApp() {
  tableAll();
  formulario();
  sedeSupervisor();
  listaEmpleado();
  listaCapital();
  formularioAE();
  obtenerData();
}

function tableAll() {
  $("#table_id").DataTable({
    destroy: true,
    ajax: {
      method: "POST",
      url: "/supervisor/capitales",
    },
    columns: [
      { data: "capital" },
      { data: "sede" },
      { data: "fecha" },
      {
        data: null,
        render: function (data, type, row) {
          return `
            <button class="btn btn-warning far fa-edit" data-idcapital="${data.id}" id="edit" data-bs-toggle="modal" data-bs-target="#modalCapital" ></button>
            <a class="btn btn-success far fa-eye" href="/supervisor/viewCapital?id=${data.id}"></a>
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
    const capital = $("#capital").val();
    const sede = $("#sede").val();

    const data = new FormData();
    data.append("precio", capital);
    data.append("idSede", sede);

    if (id == "") {
      create(data);
    } else {
      data.append("id", id);
      updateCapital(data);
    }
  });
}

function formularioAE() {
  $(document).on("submit", "#formularioCE", function (e) {
    e.preventDefault();
    const capitales = $("#capitales").val();
    const empleado = $("#empleado").val();

    const data = new FormData();
    data.append("idCapital", capitales);
    data.append("idUsuario", empleado);

    createAsignacion(data);
  });
}

function obtenerData() {
  $(document).on("click", "#edit", function (e) {
    cleanCapital();
    const idcapital = e.target.dataset.idcapital;

    const data = new FormData();
    data.append("id", idcapital);

    getCapital(data);
  });
}

async function getCapital(data) {
  const url = "http://localhost:4000/supervisor/getCapital";
  spinnerHide("flex");
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });

  if (respuesta) {
    spinnerHide("none");
  }

  const resultado = await respuesta.json();

  const { capital } = resultado;

  $("#id").val(capital.id);
  $("#capital").val(capital.precio);
  $("#sede").val(capital.idSede);
}

async function create(data) {
  const url = "http://localhost:4000/supervisor/createCapital";
  spinnerHide("flex");
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });

  if (respuesta) {
    spinnerHide("none");
  }

  const resultado = await respuesta.json();

  const { res, mensaje } = resultado;
  if (!res) {
    Swal.fire("Exito", mensaje, "success");
  } else {
    Swal.fire("Error!", mensaje, "error");
  }
}

async function sedeSupervisor() {
  const url = "http://localhost:4000/supervisor/sedeSupervisor";
  const respuesta = await fetch(url);
  const resultado = await respuesta.json();
  const { datas } = resultado;
  const sede = document.querySelector("#sede");

  datas.forEach((data) => {
    const { id, nombre, direccion, empresa } = data;
    const option = document.createElement("option");

    option.value = id;
    option.textContent = `${nombre} - Empresa: ${empresa}`;
    sede.appendChild(option);
  });
}

async function listaEmpleado() {
  const url = "http://localhost:4000/supervisor/listaEmpleados";
  const respuesta = await fetch(url);
  const resultado = await respuesta.json();

  const select = document.querySelector("#empleado");

  const { dataEmpleado } = resultado;

  dataEmpleado.forEach((e) => {
    const { id, cargo, dni, empleado } = e;

    const option = document.createElement("option");

    option.value = id;
    option.innerHTML = `${empleado} - D.N.I: ${dni}`;

    select.appendChild(option);
  });
}

async function listaCapital() {
  const url = "http://localhost:4000/supervisor/capitalAuth";
  const respuesta = await fetch(url);
  const resultado = await respuesta.json();

  const { data } = resultado;

  const select = document.querySelector("#capitales");

  data.forEach((r) => {
    const { sede, capital, fecha, id } = r;
    const option = document.createElement("option");

    option.value = id;
    option.innerHTML = `Capital: ${capital} - Sede: ${sede}`;
    select.appendChild(option);
  });
}

async function updateCapital(data) {
  const url = "http://localhost:4000/supervisor/updateCapital";
  spinnerHide("flex");
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });
  // spinner();

  if (respuesta) {
    spinnerHide("none");
  }

  const resultado = await respuesta.json();

  const { res } = resultado;
  if (!res) {
    Swal.fire("Error!", "Error al editar", "error");
  } else {
    Swal.fire("Exito!", "Se edito correctamente", "success");
    tableAll();
  }
}

async function createAsignacion(data) {
  const url = "http://localhost:4000/supervisor/asignacionEmpleado";
  spinnerHide("flex");
  const respuesta = await fetch(url, { method: "POST", body: data });

  if (respuesta) {
    spinnerHide("none");
  }

  const resultado = await respuesta.json();

  const { res, mensaje } = resultado;
  if (!res) {
    Swal.fire("Exito!", mensaje, "success");
  } else {
    Swal.fire("Error!", mensaje, "error");
  }
}

function spinnerHide(res) {
  document.querySelector("#spinner").style.display = res;
}

function cleanCapital() {
  $("#id").val("");
  $("#capital").val("");
  $("#sede").val("");
}

function cleanAsignacion() {
  $("#capitales").val("");
  $("#empleado").val("");
}
