// limpia errores inline
function limpiarErroresRol() {
  ['nombres','apellidos','telefono','usuario','contrasena','rol'].forEach(c => {
    const div = document.getElementById(`error-${c}`);
    if (div) div.textContent = '';
  });
}

// muestra errores inline
function mostrarErroresRol(errs) {
  for (const campo in errs) {
    const div = document.getElementById(`error-${campo}`);
    if (div) div.textContent = errs[campo].join(', ');
  }
}

let dataTableRol;
function listarRoles() {
  if (dataTableRol) {
    dataTableRol.destroy();
  }
  dataTableRol = $('#tablaRoles').DataTable({
    ajax: {
      url: '../ajax/empleados.php',
      type: 'POST',
      data: { accion: 'LISTAR' },
      dataSrc: 'data'
    },
    columns: [
      { data: 'nombres', title: 'Nombres' },
      { data: 'apellidos', title: 'Apellidos' },
      { data: 'telefono', title: 'Teléfono' },
      { data: 'usuario', title: 'Usuario' },
      { data: 'rol', title: 'Rol' },
      {
        data: null,
        title: 'Acciones',
        orderable: false,
        searchable: false,
        render: function(data, type, row) {
          return `
            <button class='btn btn-outline-info btn-sm rounded-pill shadow me-2' title='Editar' 
              data-id='${row.id_usuario}' 
              data-nombres='${row.nombres}' 
              data-apellidos='${row.apellidos}' 
              data-telefono='${row.telefono}' 
              data-usuario='${row.usuario}' 
              data-rol='${row.rol}'
              onclick='cargarUsuario(this)'>
              <i class='fas fa-edit'></i>
            </button>
            <button class='btn btn-outline-danger btn-sm rounded-pill shadow' title='Eliminar' onclick='eliminarUsuario(${row.id_usuario})'>
              <i class='fas fa-trash-alt'></i>
            </button>
          `;
        }
      }
    ],
    responsive: true,
    autoWidth: false,
    language: { url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
  });
}

document.addEventListener("DOMContentLoaded", function() {
  listarRoles();

  // Centrar el título principal y ponerlo en azul
  let titulo = document.querySelector(".titulo-empleados") || document.querySelector("h2");
  if (titulo) {
    titulo.classList.add("w-100", "text-center", "mb-4", "fw-bold");
    titulo.style.justifyContent = "center";
    titulo.style.display = "block";
    titulo.style.color = "#357ABD";
  }

  // Crear el botón y mensaje flotante para agregar empleado
  if (!document.getElementById("btnAgregarEmpleado")) {
    const contenedorBoton = document.createElement("div");
    contenedorBoton.className = "d-flex align-items-center justify-content-end mb-3";
    contenedorBoton.style.gap = "0.5rem";

    const mensaje = document.createElement("span");
    mensaje.className = "text-primary fw-bold";
    mensaje.style.fontSize = "1rem";
    mensaje.innerText = "Para agregar un empleado presione aquí:";

    const btnAgregar = document.createElement("button");
    btnAgregar.id = "btnAgregarEmpleado";
    btnAgregar.className = "btn btn-primary btn-sm shadow align-middle";
    btnAgregar.style.fontSize = "1rem";
    btnAgregar.style.padding = "0.35rem 0.75rem";
    btnAgregar.innerHTML = '<i class="fas fa-plus"></i>';

    contenedorBoton.appendChild(mensaje);
    contenedorBoton.appendChild(btnAgregar);

    // Insertar el botón y mensaje justo antes de la tabla
    const tabla = document.getElementById("tablaRoles");
    if (tabla && tabla.parentNode) {
      tabla.parentNode.insertBefore(contenedorBoton, tabla);
    } else {
      document.body.appendChild(contenedorBoton);
    }
  }

  // Crear el modal flotante para el formulario si no existe
  if (!document.getElementById("modalEmpleado")) {
    const modal = document.createElement("div");
    modal.id = "modalEmpleado";
    modal.className = "modal fade";
    modal.tabIndex = "-1";
    modal.role = "dialog";
    modal.innerHTML = `
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="backdrop-filter: blur(8px); background: rgba(255,255,255,0.85); border-radius: 20px; box-shadow: 0 8px 32px 0 rgba(53,122,189,0.2);">
          <div class="modal-header" style="border-bottom: 1px solid #6dd5ed;">
            <h5 class="modal-title"><i class='fas fa-user'></i> Agregar / Editar Empleado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onclick="document.getElementById('modalEmpleado').classList.remove('show');document.getElementById('modalEmpleado').style.display='none';document.body.classList.remove('modal-open');document.body.style.overflow='';if(document.querySelector('.modal-backdrop'))document.querySelector('.modal-backdrop').remove();document.getElementById('formRol').style.display='none';">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="formEmpleadoContainer"></div>
          </div>
        </div>
      </div>
    `;
    document.body.appendChild(modal);
  }

  // Mover el formulario al modal y ocultarlo por defecto
  const form = document.getElementById("formRol");
  if (form) {
    const container = document.getElementById("formEmpleadoContainer");
    if (container && !container.contains(form)) {
      container.appendChild(form);
    }
    form.style.display = "none";
  }

  // Mostrar el modal al hacer clic en el botón
  document.getElementById("btnAgregarEmpleado").onclick = function () {
    const form = document.getElementById("formRol");
    form.reset();
    form.style.display = "block";
    document.getElementById("id_usuario").value = "";
    document.getElementById("grupoContrasena").style.display = "block";
    // Mostrar el modal
    const modal = document.getElementById("modalEmpleado");
    modal.classList.add("show");
    modal.style.display = "block";
    document.body.classList.add("modal-open");
    document.body.style.overflow = "hidden";
    if (!document.querySelector('.modal-backdrop')) {
      const backdrop = document.createElement('div');
      backdrop.className = 'modal-backdrop fade show';
      document.body.appendChild(backdrop);
    }
  };

  // Guardar empleado desde el modal
  document.getElementById("btnGuardarRol").addEventListener("click", function(e) {
    e.preventDefault();
    guardarUsuario();
    // Ocultar el modal si guardado exitoso (se maneja en guardarUsuario)
  });
});

// Cargar datos en el formulario desde el botón editar (this)
function cargarUsuario(btn) {
  document.getElementById("id_usuario").value = btn.getAttribute('data-id');
  ['nombres','apellidos','telefono','usuario','rol'].forEach(campo => {
    document.getElementById(campo).value = btn.getAttribute(`data-${campo}`);
  });
  document.getElementById("grupoContrasena").style.display = "none";
  const form = document.getElementById("formRol");
  form.style.display = "block";
  const modal = document.getElementById("modalEmpleado");
  modal.classList.add("show");
  modal.style.display = "block";
  document.body.classList.add("modal-open");
  document.body.style.overflow = "hidden";
  if (!document.querySelector('.modal-backdrop')) {
    const backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';
    document.body.appendChild(backdrop);
  }
}

// Modificar guardarUsuario para ocultar el modal y el formulario al guardar
function guardarUsuario() {
  limpiarErroresRol();
  const form = document.getElementById("formRol");
  const datos= new FormData(form);
  const acc  = document.getElementById("id_usuario").value ? "MODIFICAR" : "INSERTAR";
  datos.append("accion", acc);

  fetch("../ajax/empleados.php",{method:"POST",body:datos})
    .then(r=>r.json())
    .then(data=>{
      if (data.success) {
        Swal.fire({
          icon: 'success',
          title: 'Guardado correctamente',
          timer: 2000,
          showConfirmButton: false
        });
        // Ocultar el modal y backdrop, y ocultar el formulario
        const modal = document.getElementById("modalEmpleado");
        modal.classList.remove("show");
        modal.style.display = "none";
        document.body.classList.remove("modal-open");
        document.body.style.overflow = "";
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();
        form.style.display = "none";
        listarRoles();
        form.reset();
        document.getElementById("grupoContrasena").style.display="block";
      } else if (data.errors) {
        mostrarErroresRol(data.errors);
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error al guardar',
          text: 'Ocurrió un error inesperado.'
        });
      }
    })
    .catch(e=>{
      Swal.fire({
        icon: 'error',
        title: 'Comunicación fallida',
        text: e.message
      });
    });
}

function eliminarUsuario(id) {
  Swal.fire({
    title: '¿Eliminar este usuario?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      const datos=new FormData();
      datos.append("accion","ELIMINAR");
      datos.append("id_usuario",id);
      fetch("../ajax/empleados.php",{method:"POST",body:datos})
        .then(r=>r.json())
        .then(d=>{
          Swal.fire({
            icon: d.success ? 'success' : 'error',
            title: d.success ? 'Eliminado' : 'Error al eliminar',
            timer: 2000,
            showConfirmButton: false
          });
          listarRoles();
          document.getElementById("formRol").reset();
          document.getElementById("grupoContrasena").style.display="block";
        })
        .catch(e=>{
          Swal.fire({
            icon: 'error',
            title: 'Comunicación fallida',
            text: e.message
          });
        });
    }
  });
}
