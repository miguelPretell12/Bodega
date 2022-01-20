const formulario = document.querySelector("#formulario");

const data = {
  correo: "",
  password: "",
};
document.querySelector("DOMContentLoaded", function (e) {});

iniciarSession();

function iniciarSession() {
  formulario.addEventListener("submit", function (e) {
    e.preventDefault();
    const email = document.querySelector("#correo").value;
    const password = document.querySelector("#password").value;

    const data = new FormData();
    data.append("correo", email);
    data.append("password", password);

    iniciar(data);
  });
}

async function iniciar(data) {
  const url = "http://localhost:4000/login/iniciar";
  const res = await fetch(url, {
    method: "POST",
    body: data,
  });

  const resp = await res.json();

  console.log(resp);

  const { cargo, mensaje, bool } = resp;
  if (bool) {
    if (cargo == "administrador") {
      Swal.fire("Exito!", mensaje, "success").then(() => {
        window.location.href = "/dashboard";
      });
    } else if (cargo == "supervisor") {
      Swal.fire("Exito!", mensaje, "success").then(() => {
        window.location.href = "/supervisor";
      });
    } else if (cargo == "empleado") {
      Swal.fire("Exito!", mensaje, "success").then(() => {
        window.location.href = "/employee";
      });
    }
  } else {
    Swal.fire("Error!", mensaje, "error");
  }
}
