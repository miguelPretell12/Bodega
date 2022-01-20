const body=document.querySelector("#spinner");function iniciarApp(){tableAll(),formulario(),sedeSupervisor(),listaEmpleado(),listaCapital(),formularioAE(),obtenerData()}function tableAll(){$("#table_id").DataTable({destroy:!0,ajax:{method:"GET",url:"/supervisor/capitales"},columns:[{data:"capital"},{data:"sede"},{data:"fecha"},{data:null,render:function(a,e,t){return`\n            <button class="btn btn-warning far fa-edit" data-idcapital="${a.id}" id="edit" data-bs-toggle="modal" data-bs-target="#modalCapital" ></button>\n            <a class="btn btn-success far fa-eye" href="/supervisor/viewCapital?id=${a.id}"></a>\n            `}}]})}function formulario(){$(document).on("submit","#formulario",(function(a){a.preventDefault();const e=$("#id").val(),t=$("#capital").val(),n=$("#sede").val(),i=new FormData;i.append("precio",t),i.append("idSede",n),""==e?create(i):(i.append("id",e),updateCapital(i))}))}function formularioAE(){$(document).on("submit","#formularioCE",(function(a){a.preventDefault();const e=$("#capitales").val(),t=$("#empleado").val(),n=new FormData;n.append("idCapital",e),n.append("idUsuario",t),createAsignacion(n)}))}function obtenerData(){$(document).on("click","#edit",(function(a){cleanCapital();const e=a.target.dataset.idcapital,t=new FormData;t.append("id",e),getCapital(t)}))}async function getCapital(a){spinnerHide("flex");const e=await fetch("http://localhost:4000/supervisor/getCapital",{method:"POST",body:a});e&&spinnerHide("none");const t=await e.json(),{capital:n}=t;$("#id").val(n.id),$("#capital").val(n.precio),$("#sede").val(n.idSede)}async function create(a){spinnerHide("flex");const e=await fetch("http://localhost:4000/supervisor/createCapital",{method:"POST",body:a});e&&spinnerHide("none");const t=await e.json(),{res:n,mensaje:i}=t;n?Swal.fire("Error!",i,"error"):Swal.fire("Exito",i,"success")}async function sedeSupervisor(){const a=await fetch("http://localhost:4000/supervisor/sedeSupervisor"),e=await a.json(),{datas:t}=e,n=document.querySelector("#sede");t.forEach(a=>{const{id:e,nombre:t,direccion:i,empresa:o}=a,c=document.createElement("option");c.value=e,c.textContent=`${t} - Empresa: ${o}`,n.appendChild(c)})}async function listaEmpleado(){const a=await fetch("http://localhost:4000/supervisor/listaEmpleados"),e=await a.json(),t=document.querySelector("#empleado"),{dataEmpleado:n}=e;n.forEach(a=>{const{id:e,cargo:n,dni:i,empleado:o}=a,c=document.createElement("option");c.value=e,c.innerHTML=`${o} - D.N.I: ${i}`,t.appendChild(c)})}async function listaCapital(){const a=await fetch("http://localhost:4000/supervisor/capitalAuth"),e=await a.json(),{data:t}=e,n=document.querySelector("#capitales");t.forEach(a=>{const{sede:e,capital:t,fecha:i,id:o}=a,c=document.createElement("option");c.value=o,c.innerHTML=`Capital: ${t} - Sede: ${e}`,n.appendChild(c)})}async function updateCapital(a){spinnerHide("flex");const e=await fetch("http://localhost:4000/supervisor/updateCapital",{method:"POST",body:a});e&&spinnerHide("none");const t=await e.json(),{res:n}=t;n?(Swal.fire("Exito!","Se edito correctamente","success"),tableAll()):Swal.fire("Error!","Error al editar","error")}async function createAsignacion(a){spinnerHide("flex");const e=await fetch("http://localhost:4000/supervisor/asignacionEmpleado",{method:"POST",body:a});e&&spinnerHide("none");const t=await e.json(),{res:n,mensaje:i}=t;n?Swal.fire("Error!",i,"error"):Swal.fire("Exito!",i,"success")}function spinnerHide(a){document.querySelector("#spinner").style.display=a}function cleanCapital(){$("#id").val(""),$("#capital").val(""),$("#sede").val("")}function cleanAsignacion(){$("#capitales").val(""),$("#empleado").val("")}$(document).ready((function(){iniciarApp()})),$(document).on("click","#add-capital",(function(a){cleanCapital()})),$(document).on("click","#add-asignacion",(function(a){cleanAsignacion()}));