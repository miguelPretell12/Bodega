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
          return `<button class="btn btn-${
            data.estado == "H" ? "success" : "danger"
          } fas fa-${data.estado == "H" ? "check" : "times"}-circle"
          id="status" data-idasig = "${data.id}" data-estado = "${data.estado}"
            >
            <i></i>
            </button>`;
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
    const estado = e.target.dataset.estado;
    const data = new FormData();
    data.append("id", idasig);
    data.append("estado", estado);

    updateEstado(data, e);
  });
}

async function create(data) {
  const url = " /dashboard/asignarCategoria/create";
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

async function updateEstado(data, e) {
  const url = " /dashboard/asignarCategoria/updateStatus";

  e.target.classList.remove("fa-times-circle", "fa-check-circle");
  e.target.classList.add("fa-spinner", "fa-spin");

  const respuesta = await fetch(url, { method: "POST", body: data });
  if (respuesta) {
    e.target.classList.remove("fa-spinner", "fa-spin");
  }

  const resultado = await respuesta.json();
  const { res, estado } = resultado;
  if (res) {
    if (estado == "H") {
      e.target.classList.remove("btn-danger", "fa-times-circle");
      e.target.classList.add("btn-success", "fa-check-circle");
      e.target.dataset.estado = "H";
    } else {
      e.target.classList.remove("btn-success", "fa-check-circle");
      e.target.classList.add("btn-danger", "fa-times-circle");
      e.target.dataset.estado = "I";
    }
  } else {
    Swal.fire("Error!", "Hubo un error al cambiar el estado", "error");
  }
}

async function getCategorias() {
  const url = " /dashboard/categorias/getCategorias";

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
  const url = " /dashboard/sedes/getSedes";
  const respuesta = await fetch(url);
  const resultado = await respuesta.json();

  const { data } = resultado;

  const select = document.querySelector("#sede");
  data.forEach((d) => {
    const { id, sede, empresa } = d;
    const option = document.createElement("option");
    option.value = id;
    option.textContent = `${sede} (${empresa})`;

    select.appendChild(option);
  });
}

function spinnerHide(res) {
  document.querySelector("#spinner").style.display = res;
}
