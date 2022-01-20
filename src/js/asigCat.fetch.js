$(document).ready(function (e) {
  tableAll();
  getCategorias();
  getSedes();
  formulario();
  updateStatus();
});

function tableAll() {
  $("#table_id").DataTable({
    destroy: true,
    ajax: {
      method: "GET",
      url: "/dashboard/asignarCategoria/getAsignarCats",
    },
    columns: [
      {
        data: null,
        render: function (data, type, row) {
          return `
            ${data.sede} (${data.empresa})
          `;
        },
      },
      {
        data: "direccion",
      },
      {
        data: "categoria",
      },
      {
        data: null,
        render: function (data, type, row) {
          if (data.estado == "H") {
            return `<button class="btn btn-success" id="status" data-idasig = "${data.id}">Habilitado</button>`;
          } else {
            return `<button class="btn btn-danger" id="status" data-idasig = "${data.id}">Inhabilitado</button>`;
          }
        },
      },
    ],
  });
}

function formulario() {
  $(document).on("submit", "#formulario", function (e) {
    e.preventDefault();
    const sede = $("#sede").val();
    const categoria = $("#categoria").val();
    const estado = $("#estado").val();

    const data = new FormData();
    data.append("idSede", sede);
    data.append("idCategoria", categoria);
    data.append("estado", estado);

    create(data);
  });
}

function updateStatus() {
  $(document).on("click", "#status", function (e) {
    const idasig = e.target.dataset.idasig;
    const estado =
      e.target.textContent.toLowerCase() == "habilitado" ? "H" : "I";
    const data = new FormData();
    data.append("id", idasig);
    data.append("estado", estado);

    updateEstado(data);
  });
}

async function create(data) {
  const url = "http://localhost:4000/dashboard/asignarCategoria/create";
  spinnerHide("flex");
  const respuesta = await fetch(url, { method: "POST", body: data });

  if (respuesta) {
    spinnerHide("none");
  }

  const resultado = await respuesta.json();

  const { res, mensaje } = resultado;

  if (res) {
    Swal.fire("Error!", mensaje, "error");
  } else {
    Swal.fire("Exito!", mensaje, "success");
  }
}

async function updateEstado(data) {
  const url = "http://localhost:4000/dashboard/asignarCategoria/updateStatus";
  spinnerHide("flex");
  const respuesta = await fetch(url, { method: "POST", body: data });
  if (respuesta) {
    spinnerHide("none");
    tableAll();
  }

  const resultado = await respuesta.json();
  const { res } = resultado;
  if (res) {
    Swal.fire("Exito!", "Se pudo cambiar el estado correctamente", "success");
  } else {
    Swal.fire("Error!", "Hubo un error al cambiar el estado", "error");
  }
}

async function getCategorias() {
  const url = "http://localhost:4000/dashboard/categorias/getCategorias";

  const respuesta = await fetch(url);

  const resultado = await respuesta.json();

  const { data } = resultado;

  const select = document.querySelector("#categoria");
  data.forEach((d) => {
    const { id, nombre } = d;
    const option = document.createElement("option");
    option.value = id;
    option.textContent = nombre;

    select.appendChild(option);
  });
}

async function getSedes() {
  const url = "http://localhost:4000//dashboard/sedes/getSedes";
  const respuesta = await fetch(url);
  const resultado = await respuesta.json();

  const { data } = resultado;

  const select = document.querySelector("#sede");
  data.forEach((d) => {
    const { id, nombre, empresa } = d;
    const option = document.createElement("option");
    option.value = id;
    option.textContent = `${nombre} (${empresa})`;

    select.appendChild(option);
  });
}

function spinnerHide(res) {
  document.querySelector("#spinner").style.display = res;
}
