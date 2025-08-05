function obtenerParametroURL(nombre) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(nombre);
}

function cargarEventos() {
  $.getJSON("../ajax/cocinero.php?action=eventos", function (data) {
    if (data.status === "success") {
      let options = '<option value="">-- Selecciona un evento --</option>';
      data.eventos.forEach(ev => {
        options += `<option value="${ev}">${ev}</option>`;
      });
      $('#selectEvento').html(options);
    }
  });
}

function cargarPedidosPorEvento(nombreEvento, callback) {
  $.getJSON("../ajax/cocinero.php?action=listarPorEvento&evento=" + encodeURIComponent(nombreEvento), function (data) {
    if (data.status === "success") {
      let tbody = "";
      data.pedidos.forEach(pedido => {
        let opcionesRepartidor = `<option value="">-- Repartidor --</option>`;
        data.repartidores.forEach(r => {
          opcionesRepartidor += `<option value="${r.id_repartidor}" ${pedido.id_repartidor == r.id_repartidor ? 'selected' : ''}>${r.nombre_repartidor}</option>`;
        });

        tbody += `
          <tr>
            <td>${pedido.nombre_cliente}</td>
            <td>${pedido.fecha_pedido}</td>
            <td>${pedido.tiempo_estimado} min</td>
            <td>$${pedido.total.toFixed(2)}</td>
            <td>
              <select class="form-control estado-select" data-id="${pedido.id_pedido}">
                <option value="Preparando" ${pedido.estado === 'Preparando' ? 'selected' : ''}>Preparando</option>
                <option value="En camino" ${pedido.estado === 'En camino' ? 'selected' : ''}>En camino</option>
              </select>
            </td>
            <td>
              <select class="form-control repartidor-select" data-id="${pedido.id_pedido}">
                ${opcionesRepartidor}
              </select>
            </td>
            <td>
              <button class="btn btn-primary btn-enviar" data-id="${pedido.id_pedido}">
                Confirmar envío
              </button>
            </td>
          </tr>
        `;
      });

      $("#tablaPedidos tbody").html(tbody);

      if (typeof callback === "function") {
        callback();
      }
    }
  });
}

$(document).ready(function () {
  cargarEventos();

  const pedidoIdURL = obtenerParametroURL("id_pedido");

  $('#selectEvento').on('change', function () {
    const evento = $(this).val();
    if (evento !== "") {
      cargarPedidosPorEvento(evento, () => {
        if (pedidoIdURL) {
          resaltarPedido(pedidoIdURL);
        }
      });
    } else {
      $("#tablaPedidos tbody").html("");
    }
  });

  // Si se pasó un ID de pedido por la URL, intenta cargar todos los pedidos para encontrarlo
  if (pedidoIdURL) {
    $.getJSON("../ajax/cocinero.php?action=listar", function (data) {
      if (data.status === "success") {
        let tbody = "";
        data.pedidos.forEach(pedido => {
          let opcionesRepartidor = `<option value="">-- Repartidor --</option>`;
          data.repartidores.forEach(r => {
            opcionesRepartidor += `<option value="${r.id_repartidor}" ${pedido.id_repartidor == r.id_repartidor ? 'selected' : ''}>${r.nombre_repartidor}</option>`;
          });

          tbody += `
            <tr>
              <td>${pedido.nombre_cliente}</td>
              <td>${pedido.fecha_pedido}</td>
              <td>${pedido.tiempo_estimado} min</td>
              <td>$${pedido.total.toFixed(2)}</td>
              <td>
                <select class="form-control estado-select" data-id="${pedido.id_pedido}">
                  <option value="Preparando" ${pedido.estado === 'Preparando' ? 'selected' : ''}>Preparando</option>
                  <option value="En camino" ${pedido.estado === 'En camino' ? 'selected' : ''}>En camino</option>
                </select>
              </td>
              <td>
                <select class="form-control repartidor-select" data-id="${pedido.id_pedido}">
                  ${opcionesRepartidor}
                </select>
              </td>
              <td>
                <button class="btn btn-primary btn-enviar" data-id="${pedido.id_pedido}">
                  Confirmar envío
                </button>
              </td>
            </tr>
          `;
        });

        $("#tablaPedidos tbody").html(tbody);

        setTimeout(() => {
          resaltarPedido(pedidoIdURL);
        }, 300);
      }
    });
  }

  $("#tablaPedidos").on("click", ".btn-enviar", function () {
    const id = $(this).data("id");
    const estado = $(`.estado-select[data-id="${id}"]`).val();
    const repartidor = $(`.repartidor-select[data-id="${id}"]`).val();

    if (!estado || !repartidor) {
      Swal.fire({
        icon: "warning",
        title: "Faltan datos",
        text: "Debes seleccionar estado y repartidor.",
        confirmButtonText: "Aceptar"
      });
      return;
    }

    $.post("../ajax/cocinero.php?action=procesarEntrega", {
      id_pedido: id,
      estado: estado,
      id_repartidor: repartidor
    }, function (res) {
      const r = JSON.parse(res);
      if (r.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Pedido actualizado",
          text: "Se ha actualizado el estado del pedido.",
          timer: 2000,
          showConfirmButton: false
        });

        const eventoSeleccionado = $('#selectEvento').val();
        if (eventoSeleccionado) {
          cargarPedidosPorEvento(eventoSeleccionado, () => {
            if (pedidoIdURL) {
              resaltarPedido(pedidoIdURL);
            }
          });
        }
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se pudo actualizar el pedido.",
          confirmButtonText: "Aceptar"
        });
      }
    });
  });
});

function resaltarPedido(id) {
  const filaObjetivo = $(`#tablaPedidos tbody tr`).filter(function () {
    return $(this).find('.btn-enviar').data('id') == id;
  });

  if (filaObjetivo.length > 0) {
    filaObjetivo.css({
      backgroundColor: "#fff3cd", // amarillo claro
      border: "2px solid #ffc107"
    });
    $('html, body').animate({
      scrollTop: filaObjetivo.offset().top - 150
    }, 800);
  }
}
