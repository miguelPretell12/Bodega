$(document).ready(function () {
  tableAll();
  getCargos();
  formulario();
  obtenerData();
  deleteUsuario();
  // getSedes();
  getUsuarios();
});

async function create(data) {
  const url = " /dashboard/usuarios/create";
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });

  const resultado = await respuesta.json();

  const { res, mensaje } = resultado;
  if (!res) {
    Swal.fire("Exito", mensaje, "success");
    tableAll();
  } else {
    Swal.fire("Error!", mensaje, "error");
  }
}

async function update(data) {
  const url = " /dashboard/usuarios/update";
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });

  const resultado = await respuesta.json();

  const { res } = resultado;

  if (res) {
    Swal.fire("Exito", "Se edito correctamente el usuario", "success");
    tableAll();
  } else {
    Swal.fire("Error!", "Hubo un error al editar el usuario", "error");
  }
}

async function remove(data) {
  const url = " /dashboard/usuarios/delete";
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });

  const resultado = await respuesta.json();
  const { res } = resultado;

  if (res) {
    Swal.fire(
      "Eliminado!",
      "El Usuario ha sido eliminado correctamente",
      "success"
    );
  } else {
    Swal.fire(
      "Error!",
      "El usuario no ha sido eliminado correctamente",
      "error"
    );
  }
}

async function getUsuario(data) {
  const url = " /dashboard/usuarios/getUsuario";
  const respuesta = await fetch(url, {
    method: "POST",
    body: data,
  });

  const resultado = await respuesta.json();
  const { id, nombre, apellido, dni, correo, password, idCargo, estado } =
    resultado.data;

  console.log(resultado);
  $("#id").val(id);
  $("#nombre").val(nombre);
  $("#apellido").val(apellido);
  $("#dni").val(dni);
  $("#correo").val(correo);
  $("#password").val(password);
  $("#cargo").val(idCargo);
  $("#estado").val(estado);
}

async function getCargos() {
  const url = " /dashboard/cargos/lists";
  const respuesta = await fetch(url);

  const resultado = await respuesta.json();

  const { data } = resultado;
  const select = document.querySelector("#cargo");
  data.forEach((d) => {
    const option = document.createElement("option");

    option.textContent = d.nombre;
    option.value = d.id;

    select.appendChild(option);
  });
  console.log(data);
}

async function getSedes() {
  const url = " /dashboard/sedes/getSedes";
  const respuesta = await fetch(url);

  const resultado = await respuesta.json();

  const select = document.querySelector("#sede");
  const { data } = resultado;

  data.forEach((d) => {
    const option = document.createElement("option");

    option.value = d.id;
    option.textContent = ` ${d.nombre} - ${d.empresa}`;

    select.appendChild(option);
  });
}

async function getUsuarios() {
  const url = " /dashboard/usuarios/getUsuarios";
  const respuesta = await fetch(url);

  const resultado = await respuesta.json();

  const select = document.querySelector("#supervisor");
  const { data } = resultado;

  data.forEach((d) => {
    const { cargo, nombre, id, estado } = d;
    const option = document.createElement("option");

    if (
      (cargo.trim() == "supervisor" || cargo == "administrador") &&
      estado == "A"
    ) {
      option.value = id;
      option.textContent = nombre;
      select.appendChild(option);
    }
  });

  console.log(resultado);
}

function tableAll() {
  $("#table_id").DataTable({
    destroy: true,
    ajax: {
      method: "GET",
      url: "/dashboard/usuarios/getUsuarios",
    },
    columns: [
      {
        data: "nombre",
      },
      {
        data: "correo",
      },
      {
        data: "dni",
      },
      {
        data: "cargo",
      },
      {
        data: "estado",
      },
      {
        data: null,
        render: function (data, type, row) {
          return `
            <button class="btn btn-warning far fa-edit" data-idusuario="${data.id}" id="edit" data-bs-toggle="modal" data-bs-target="#modalUsuario" ></button>
          <button class="btn btn-danger far fa-trash-alt" data-idusuario="${data.id}" id="delete"></button>
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
    const apellido = $("#apellido").val();
    const dni = $("#dni").val();
    const correo = $("#correo").val();
    const contrasenia = $("#password").val();
    const cargo = $("#cargo").val();
    const estado = $("#estado").val();
    const supervisor = $("#supervisor").val();
    // Form Data
    const data = new FormData();
    data.append("nombre", nombre);
    data.append("apellido", apellido);
    data.append("dni", dni);
    data.append("correo", correo);
    data.append("password", contrasenia);
    data.append("idCargo", cargo);
    data.append("estado", estado);
    data.append("idSupervisor", supervisor);
    if (
      nombre == "" ||
      apellido == "" ||
      dni == "" ||
      correo == "" ||
      contrasenia == "" ||
      cargo == "" ||
      estado == ""
    ) {
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
    clean();
    const id = e.target.dataset.idusuario;
    const password = document.querySelector("#password").parentElement;
    password.style.display = "none";
    $("#title").text("Editar Usuario");
    const data = new FormData();
    data.append("id", id);

    getUsuario(data);
  });
}

function clean() {
  $("#id").val("");
  $("#nombre").val("");
  $("#apellido").val("");
  $("#dni").val("");
  $("#correo").val("");
  $("#password").val("");
  $("#cargo").val("");
  $("#estado").val("");
}

function deleteUsuario() {
  $(document).on("click", "#delete", function (e) {
    const idusuario = e.target.dataset.idusuario;

    const data = new FormData();
    data.append("id", idusuario);
    // remove(data);
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

$(document).on("click", "#btn-register", function (e) {
  clean();
  $("#title").text("Registrar Usuario");
});

$(document).on("click", "#password", function (e) {
  e.target.value = "";
});
