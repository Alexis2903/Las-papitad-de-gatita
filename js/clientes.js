// Inicializa botones y formulario
function inicializarEventosClientes() {
  const btnGuardar  = document.getElementById("btnGuardar");
  const btnCancelar = document.getElementById("btnCancelar");
  const formCliente = document.getElementById("formCliente");

  if (btnGuardar && btnCancelar && formCliente) {
    formCliente.style.display = "block";
    btnGuardar.addEventListener("click", guardarCliente);
    btnCancelar.addEventListener("click", () => {
      formCliente.reset();
      document.getElementById("id_usuario").value = "";
      limpiarErrores();
      formCliente.style.display = "block";
    });
  }
}

// Borra errores existentes
function limpiarErrores() {
  ['nombres','apellidos','telefono','usuario'].forEach(campo => {
    const div = document.getElementById(`error-${campo}`);
    if (div) div.textContent = '';
  });
}

// Muestra errores debajo de cada campo
function mostrarErrores(errores) {
  for (const campo in errores) {
    const div = document.getElementById(`error-${campo}`);
    if (div) div.textContent = errores[campo].join(', ');
  }
}

// Carga la tabla de clientes
function listarClientes() {
  const datos = new FormData();
  datos.append("accion", "LISTAR");

  fetch("../ajax/clientes.php", {
    method: "POST",
    body: datos,
  })
    .then(res => res.text())
    .then(html => {
      document.getElementById("tablaClientes").innerHTML = html;

      if ($.fn.DataTable.isDataTable("#tablaListado")) {
        $('#tablaListado').DataTable().destroy();
      }

      $('#tablaListado').DataTable({
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        }
      });

      // Moderniza los botones de acción y asigna eventos igual que empleados
      $("#tablaListado tbody tr").each(function() {
        const $tr = $(this);
        const $tdAcciones = $tr.find("td:last");
        const editarBtn = $tdAcciones.find("button[title='Editar']");
        const eliminarBtn = $tdAcciones.find("button[title='Eliminar']");
        if (editarBtn.length) {
          editarBtn
            .removeClass()
            .addClass('btn btn-outline-info btn-sm rounded-pill shadow me-2')
            .attr('title', 'Editar')
            .html('<i class="fas fa-edit"></i>');
          editarBtn.off('click').on('click', function() {
            const cliente = JSON.parse($tr.attr('data-cliente'));
            cargarCliente(cliente);
          });
        }
        if (eliminarBtn.length) {
          eliminarBtn
            .removeClass()
            .addClass('btn btn-outline-danger btn-sm rounded-pill shadow')
            .attr('title', 'Eliminar')
            .html('<i class="fas fa-trash-alt"></i>');
          eliminarBtn.off('click').on('click', function() {
            const cliente = JSON.parse($tr.attr('data-cliente'));
            eliminarCliente(cliente.id_usuario);
          });
        }
      });

      inicializarEventosClientes();
    })
    .catch(err => {
      Swal.fire({
        icon: "error",
        title: "Error de red",
        text: "No se pudo cargar la lista de clientes: " + err.message
      });
    });
}

// Inserta o modifica cliente
function guardarCliente() {
  const form       = document.getElementById("formCliente");
  const datos      = new FormData(form);
  const id_usuario = document.getElementById("id_usuario").value;
  datos.append("accion", id_usuario ? "MODIFICAR" : "INSERTAR");

  limpiarErrores();

  fetch("../ajax/clientes.php", {
    method: "POST",
    body: datos,
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
          icon: "success",
          title: "¡Éxito!",
          text: "Guardado correctamente",
          timer: 1200,
          showConfirmButton: false
        }).then(() => {
          window.location.reload();
        });
      } else if (data.errors) {
        mostrarErrores(data.errors);
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Error desconocido al guardar"
        });
      }
    })
    .catch(err => {
      Swal.fire({
        icon: "error",
        title: "Error de red",
        text: "Error de comunicación con el servidor: " + err.message
      });
    });
}

// Elimina cliente
function eliminarCliente(id) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "Esta acción eliminará al cliente",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      const datos = new FormData();
      datos.append("accion", "ELIMINAR");
      datos.append("id_usuario", id);

      fetch("../ajax/clientes.php", {
        method: "POST",
        body: datos,
      })
        .then(res => res.json())
        .then(data => {
          Swal.fire({
            icon: data.success ? "success" : "error",
            title: data.success ? "Eliminado" : "Error",
            text: data.success ? "Cliente eliminado" : "No se pudo eliminar"
          });
          listarClientes();
        })
        .catch(err => {
          Swal.fire({
            icon: "error",
            title: "Error de red",
            text: "Error de comunicación: " + err.message
          });
        });
    }
  });
}

// Carga datos en formulario para editar
function cargarCliente(c) {
  const form = document.getElementById("formCliente");
  document.getElementById("id_usuario").value = c.id_usuario;
  document.getElementById("nombres").value    = c.nombres;
  document.getElementById("apellidos").value  = c.apellidos;
  document.getElementById("telefono").value   = c.telefono;
  document.getElementById("usuario").value    = c.usuario;
  // Abre el modal Bootstrap
  const modal = new bootstrap.Modal(document.getElementById('modalCliente'));
  modal.show();
}

// Al cargar la página, lista clientes
document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById("tablaClientes")) {
    listarClientes();
  }
});
