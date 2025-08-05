let dataTable;

function limpiarErroresProducto() {
  ['nombre', 'descripcion', 'precio', 'tiempo_preparacion'].forEach(campo => {
    const div = document.getElementById(`error-${campo}`);
    if (div) div.textContent = '';
  });
}

function mostrarErroresProducto(errores) {
  for (const campo in errores) {
    const div = document.getElementById(`error-${campo}`);
    if (div) div.textContent = errores[campo].join(', ');
  }
}

function listar() {
  const datos = new FormData();
  datos.append("accion", "LISTAR");

  fetch("../ajax/productos.php", {
    method: "POST",
    body: datos
  })
    .then(res => res.text())
    .then(html => {
      const tabla = document.getElementById("tabla");
      tabla.innerHTML = html;

      if ($.fn.DataTable.isDataTable('#tabla')) {
        $('#tabla').DataTable().destroy();
      }

      dataTable = $('#tabla').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
          url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
        }
      });
    });
}

function cargarEventosExistentes() {
  const datos = new FormData();
  datos.append("accion", "LISTAR_EVENTOS");

  fetch("../ajax/productos.php", {
    method: "POST",
    body: datos
  })
    .then(res => res.json())
    .then(eventos => {
      const select = document.getElementById("evento_existente");
      select.innerHTML = '<option value="">-- Selecciona un evento --</option>';
      eventos.forEach(e => {
        const option = document.createElement("option");
        option.value = `${e.nombre_evento}|${e.fecha_evento}`;
        option.textContent = `${e.nombre_evento} (${e.fecha_evento})`;
        select.appendChild(option);
      });
    });
}

document.getElementById("tipo_producto").addEventListener("change", function () {
  const grupoEvento = document.getElementById("grupo_evento");
  const grupoFechaEvento = document.getElementById("grupo_fecha_evento");
  const grupoEventoExistente = document.getElementById("grupo_evento_existente");

  if (this.value === "Evento") {
    grupoEvento.style.display = "block";
    grupoFechaEvento.style.display = "block";
    grupoEventoExistente.style.display = "block";
    cargarEventosExistentes();
  } else {
    grupoEvento.style.display = "none";
    grupoFechaEvento.style.display = "none";
    grupoEventoExistente.style.display = "none";
    document.getElementById("nombre_evento").value = "";
    document.getElementById("fecha_evento").value = "";
    document.getElementById("evento_existente").value = "";
  }
});

document.getElementById("evento_existente").addEventListener("change", function () {
  const valor = this.value;
  if (valor) {
    const [nombreEvento, fechaEvento] = valor.split("|");
    document.getElementById("nombre_evento").value = nombreEvento;
    document.getElementById("fecha_evento").value = fechaEvento;
  } else {
    document.getElementById("nombre_evento").value = "";
    document.getElementById("fecha_evento").value = "";
  }
});

function guardar() {
  limpiarErroresProducto();
  const form = document.getElementById("formProducto");
  const datos = new FormData(form);
  const accion = document.getElementById("id_producto").value ? "MODIFICAR" : "INSERTAR";
  datos.append("accion", accion);

  const tipo = document.getElementById("tipo_producto").value;
  const nombreEvento = tipo === "Evento" ? document.getElementById("nombre_evento").value : '';
  const fechaEvento = tipo === "Evento" ? document.getElementById("fecha_evento").value : null;

  datos.set("nombre_evento", nombreEvento);
  datos.set("fecha_evento", fechaEvento);

  fetch("../ajax/productos.php", {
    method: "POST",
    body: datos
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
          icon: "success",
          title: "¡Éxito!",
          text: "Guardado correctamente",
          timer: 2000,
          showConfirmButton: false
        });

        const modal = document.getElementById("modalProducto");
        modal.classList.remove("show");
        modal.style.display = "none";
        document.body.classList.remove("modal-open");
        document.body.style.overflow = "";
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();
        form.style.display = "none";

        listar();
        form.reset();
        document.getElementById("id_producto").value = "";
        document.getElementById("imagen_actual").value = "";
        document.getElementById("grupo_evento").style.display = "none";
        document.getElementById("grupo_fecha_evento").style.display = "none";
        document.getElementById("grupo_evento_existente").style.display = "none";
      } else if (data.errors) {
        mostrarErroresProducto(data.errors);
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Error al guardar"
        });
      }
    })
    .catch(err => {
      Swal.fire({
        icon: "error",
        title: "Error de red",
        text: "No se pudo guardar: " + err.message
      });
    });
}

function eliminar(id) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "Esta acción eliminará el producto",
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
      datos.append("id_producto", id);

      fetch("../ajax/productos.php", {
        method: "POST",
        body: datos
      })
        .then(res => res.json())
        .then(data => {
          Swal.fire({
            icon: data.success ? "success" : "error",
            title: data.success ? "Eliminado" : "Error",
            text: data.success ? "Producto eliminado" : "No se pudo eliminar"
          });
          listar();
          document.getElementById("formProducto").reset();
          document.getElementById("id_producto").value = "";
          document.getElementById("imagen_actual").value = "";
          document.getElementById("grupo_evento").style.display = "none";
          document.getElementById("grupo_fecha_evento").style.display = "none";
          document.getElementById("grupo_evento_existente").style.display = "none";
        })
        .catch(err => {
          Swal.fire({
            icon: "error",
            title: "Error de red",
            text: "No se pudo eliminar: " + err.message
          });
        });
    }
  });
}

function cargar(p) {
  const form = document.getElementById("formProducto");
  form.style.display = "block";
  document.getElementById("id_producto").value = p.id_producto;
  document.getElementById("nombre").value = p.nombre;
  document.getElementById("descripcion").value = p.descripcion;
  document.getElementById("precio").value = p.precio;
  document.getElementById("tiempo_preparacion").value = p.tiempo_preparacion;
  document.getElementById("imagen_actual").value = p.imagen;

  const tipoProducto = p.nombre_evento && p.nombre_evento.trim() !== "" && p.nombre_evento.toLowerCase() !== "normal" ? "Evento" : "Normal";
  document.getElementById("tipo_producto").value = tipoProducto;

  if (tipoProducto === "Evento") {
    document.getElementById("grupo_evento").style.display = "block";
    document.getElementById("grupo_fecha_evento").style.display = "block";
    document.getElementById("grupo_evento_existente").style.display = "block";
    document.getElementById("nombre_evento").value = p.nombre_evento;
    document.getElementById("fecha_evento").value = p.fecha_evento || "";
    cargarEventosExistentes();
  } else {
    document.getElementById("grupo_evento").style.display = "none";
    document.getElementById("grupo_fecha_evento").style.display = "none";
    document.getElementById("grupo_evento_existente").style.display = "none";
    document.getElementById("nombre_evento").value = "";
    document.getElementById("fecha_evento").value = "";
  }

  const modal = document.getElementById("modalProducto");
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

window.onload = function () {
  listar();

  if (!document.getElementById("btnAgregarProducto")) {
    const contenedorBoton = document.createElement("div");
    contenedorBoton.className = "d-flex align-items-center ms-auto";
    contenedorBoton.style.gap = "0.5rem";

    const mensaje = document.createElement("span");
    mensaje.className = "text-primary fw-bold";
    mensaje.style.fontSize = "1rem";
    mensaje.innerText = "Para agregar un producto presione aquí:";

    const btnAgregar = document.createElement("button");
    btnAgregar.id = "btnAgregarProducto";
    btnAgregar.className = "btn btn-primary btn-sm shadow align-middle";
    btnAgregar.style.fontSize = "1rem";
    btnAgregar.style.padding = "0.35rem 0.75rem";
    btnAgregar.innerHTML = '<i class="fas fa-plus"></i>';

    contenedorBoton.appendChild(mensaje);
    contenedorBoton.appendChild(btnAgregar);

    let titulo = document.querySelector(".titulo-productos") || document.querySelector("h1");
    if (titulo) {
      titulo.classList.add("d-flex", "align-items-center");
      titulo.style.gap = "0.5rem";
      titulo.appendChild(contenedorBoton);
    } else {
      const tabla = document.getElementById("tabla");
      if (tabla && tabla.parentNode) {
        tabla.parentNode.insertBefore(contenedorBoton, tabla);
      } else {
        document.body.appendChild(contenedorBoton);
      }
    }
  }

  if (!document.getElementById("modalProducto")) {
    const modal = document.createElement("div");
    modal.id = "modalProducto";
    modal.className = "modal fade";
    modal.tabIndex = "-1";
    modal.role = "dialog";
    modal.innerHTML = `
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="backdrop-filter: blur(8px); background: rgba(255,255,255,0.85); border-radius: 20px; box-shadow: 0 8px 32px 0 rgba(53,122,189,0.2);">
          <div class="modal-header" style="border-bottom: 1px solid #6dd5ed;">
            <h5 class="modal-title"><i class='fas fa-box'></i> Agregar / Editar Producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onclick="document.getElementById('modalProducto').classList.remove('show');document.getElementById('modalProducto').style.display='none';document.body.classList.remove('modal-open');document.body.style.overflow='';document.querySelector('.modal-backdrop').remove();">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="formProductoContainer"></div>
          </div>
        </div>
      </div>
    `;
    document.body.appendChild(modal);
  }

  const form = document.getElementById("formProducto");
  if (form) {
    const container = document.getElementById("formProductoContainer");
    if (container && !container.contains(form)) {
      container.appendChild(form);
    }
    form.style.display = "none";
  }

  document.getElementById("btnAgregarProducto").onclick = function () {
    const form = document.getElementById("formProducto");
    form.reset();
    form.style.display = "block";
    document.getElementById("id_producto").value = "";
    document.getElementById("imagen_actual").value = "";
    document.getElementById("grupo_evento").style.display = "none";
    document.getElementById("grupo_fecha_evento").style.display = "none";
    document.getElementById("grupo_evento_existente").style.display = "none";
    document.getElementById("evento_existente").value = "";
    const modal = document.getElementById("modalProducto");
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

  document.getElementById("btnGuardar").addEventListener("click", function (e) {
    e.preventDefault();
    guardar();
  });

  const tabla = document.getElementById("tabla");
  if (tabla) {
    tabla.classList.add("table", "table-bordered", "table-hover", "table-lg");
    tabla.style.fontSize = "1.15rem";
    tabla.style.width = "100%";
    tabla.style.maxWidth = "1400px";
    tabla.style.margin = "0 auto";
  }
};
