let map;

function mostrarMapa(lat, lng) {
  const location = { lat: lat, lng: lng };
  map = new google.maps.Map(document.getElementById("map"), {
    center: location,
    zoom: 16,
  });
  new google.maps.Marker({ position: location, map });
}

function cargarPedidos() {
  $.getJSON("../ajax/repartidor.php?action=listar", function (data) {
    if (data.status === "success") {
      let tbody = "";
      data.data.forEach(function (pedido) {
        const demoraRegistrada = pedido.hora_demora && pedido.hora_demora !== '00:00:00';
        const pagoRegistrado = pedido.pago_viaje && parseFloat(pedido.pago_viaje) > 0;

        tbody += `
          <tr style="background:#f6fbff;border-radius:12px;transition:background-color 0.3s;">
            <td style="vertical-align:middle;text-align:center;padding:14px 12px;font-weight:500;color:#222;">${pedido.nombre_cliente}</td>
            <td style="vertical-align:middle;text-align:center;padding:14px 12px;font-weight:500;color:#222;">${pedido.telefono_cliente}</td>
            <td style="vertical-align:middle;text-align:center;padding:14px 12px;font-weight:500;color:#222;">$${parseFloat(pedido.total).toFixed(2)}</td>
            <td style="vertical-align:middle;text-align:center;padding:14px 12px;">
              <button class="btn-ver-mapa"
                data-lat="${pedido.latitud_entrega}"
                data-lng="${pedido.longitud_entrega}"
                title="Ver ubicación">
                <i class="fas fa-map-marker-alt"></i> Mapa
              </button>
            </td>
            <td style="vertical-align:middle;text-align:center;padding:14px 12px;">
              ${demoraRegistrada ? pedido.hora_demora : '00:00:00'}
              <br/>
              <button class="btn-registrar-demora"
                data-id="${pedido.id_pedido}"
                title="${demoraRegistrada ? 'Demora ya ingresada' : 'Ingresar demora'}"
                ${demoraRegistrada ? 'disabled' : ''}
              >
                <i class="fas fa-clock"></i> ${demoraRegistrada ? 'Ingresada' : 'Ingresar'}
              </button>
            </td>
            <td style="vertical-align:middle;text-align:center;padding:14px 12px;color:#222;font-weight:600;">
              $<span class="pago-viaje-valor" data-id="${pedido.id_pedido}">${pedido.pago_viaje}</span>
              <br/>
              <button class="btn-registrar-pago"
                data-id="${pedido.id_pedido}"
                title="${pagoRegistrado ? 'Pago ya ingresado' : 'Ingresar pago'}"
                ${pagoRegistrado ? 'disabled' : ''}
              >
                <i class="fas fa-dollar-sign"></i> ${pagoRegistrado ? 'Ingresado' : 'Ingresar'}
              </button>
            </td>
            <td style="vertical-align:middle;text-align:center;padding:14px 12px;">
              <button class="btn-entregar"
                data-id="${pedido.id_pedido}"
                title="Registrar entrega">
                <i class="fas fa-check"></i> Entregar
              </button>
            </td>
          </tr>
        `;
      });
      $("#tablaPedidos tbody").html(tbody);
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se pudieron obtener los pedidos.',
        confirmButtonText: 'Aceptar'
      });
    }
  });
}

function obtenerUbicacion(callback) {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
      const lat = position.coords.latitude;
      const lng = position.coords.longitude;
      callback(lat, lng);
    }, function () {
      Swal.fire({
        icon: 'warning',
        title: 'Ubicación no disponible',
        text: 'Asegúrate de haber permitido la geolocalización.',
        confirmButtonText: 'Entendido'
      });
    });
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Geolocalización no soportada',
      text: 'Tu navegador no soporta geolocalización.',
      confirmButtonText: 'Aceptar'
    });
  }
}

$(document).ready(function () {
  cargarPedidos();

  $("#tablaPedidos tbody").on("click", ".btn-ver-mapa", function () {
    const lat = parseFloat($(this).data("lat"));
    const lng = parseFloat($(this).data("lng"));

    $("#modalMapa").modal("show");
    $("#modalMapa").on("shown.bs.modal", function () {
      $("#map").empty();
      mostrarMapa(lat, lng);
      google.maps.event.trigger(map, "resize");
      $("#modalMapa").off("shown.bs.modal");
    });
  });

  $("#tablaPedidos tbody").on("click", ".btn-registrar-demora", function () {
    const id = $(this).data("id");

    Swal.fire({
      title: "Ingrese minutos de demora",
      input: 'number',
      inputLabel: 'Minutos',
      inputAttributes: { min: 0, step: 1 },
      showCancelButton: true,
      confirmButtonText: "Ingresar demora",
      cancelButtonText: "Cancelar",
      inputValidator: (value) => {
        if (!value) {
          return 'Debes ingresar los minutos de demora';
        }
        if (value < 0) {
          return 'Minutos no pueden ser negativos';
        }
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const minutos = parseInt(result.value);
        const horaDemora = `00:${minutos.toString().padStart(2, '0')}:00`; // HH:mm:ss

        $.post("../ajax/repartidor.php?action=registrar_demora", { id_pedido: id, hora_demora: horaDemora }, function (res) {
          const response = JSON.parse(res);
          if (response.status === "success") {
            Swal.fire({
              icon: 'success',
              title: 'Demora ingresada',
              text: response.message,
              timer: 1500,
              showConfirmButton: false
            });
            cargarPedidos();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.message,
              confirmButtonText: 'Aceptar'
            });
          }
        });
      }
    });
  });

  $("#tablaPedidos tbody").on("click", ".btn-registrar-pago", function () {
    const id = $(this).data("id");
    const valorActual = $(`.pago-viaje-valor[data-id="${id}"]`).text();

    Swal.fire({
      title: "Ingrese el pago del viaje",
      input: 'number',
      inputLabel: 'Monto en dólares',
      inputValue: valorActual,
      inputAttributes: { min: 0, step: 0.01 },
      showCancelButton: true,
      confirmButtonText: "Ingresar pago",
      cancelButtonText: "Cancelar",
      inputValidator: (value) => {
        if (!value) {
          return 'Debes ingresar un monto';
        }
        if (parseFloat(value) < 0) {
          return 'El monto no puede ser negativo';
        }
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const pagoViaje = parseFloat(result.value).toFixed(2);

        $.post("../ajax/repartidor.php?action=registrar_pago", { id_pedido: id, pago_viaje: pagoViaje }, function (res) {
          const response = JSON.parse(res);
          if (response.status === "success") {
            Swal.fire({
              icon: 'success',
              title: 'Pago ingresado',
              text: response.message,
              timer: 1500,
              showConfirmButton: false
            });
            cargarPedidos();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.message,
              confirmButtonText: 'Aceptar'
            });
          }
        });
      }
    });
  });

  $("#tablaPedidos tbody").on("click", ".btn-entregar", function () {
    const id = $(this).data("id");

    obtenerUbicacion(function (lat, lng) {
      $.post("../ajax/repartidor.php?action=entregar", { id_pedido: id, latitud: lat, longitud: lng }, function (res) {
        const response = JSON.parse(res);
        if (response.status === "success") {
          Swal.fire({
            icon: 'success',
            title: 'Entrega registrada',
            text: response.message,
            timer: 1500,
            showConfirmButton: false
          });
          cargarPedidos();
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.message,
            confirmButtonText: 'Aceptar'
          });
        }
      });
    });
  });
});
