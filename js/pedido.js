let carrito = [];
const rutaBaseImagen = '../vistas/Imagenes/';
const keyUbicacion = 'ubicacion_cliente';

function cargarProductos(tipo) {
    $.get(`../ajax/pedido.php?op=listar&tipo=${tipo}`, function(data) {
        const productos = JSON.parse(data);
        let html = '';

        if (productos.length === 0) {
            html = '<p>No hay productos para este evento.</p>';
        } else {
            productos.forEach(p => {
                html += `
                    <div class="col-md-4 mb-4">
                        <div class="card producto-card">
                            <img src="${rutaBaseImagen + p.imagen}" alt="${p.nombre}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title fw-bold" style="font-size:1.3rem;letter-spacing:1px;background:linear-gradient(90deg,#2193b0,#6dd5ed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">${p.nombre}</h5>
                                <p class="card-text text-secondary mb-2">${p.descripcion}</p>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge" style="background:linear-gradient(90deg,#43ea7b,#2dbd6e);color:#fff;font-size:1rem;padding:7px 16px;border-radius:14px;font-weight:600;box-shadow:0 2px 8px #2dbd6e50;">$${p.precio}</span>
                                    <span class="badge" style="background:linear-gradient(90deg,#2193b0,#6dd5ed);color:#fff;font-size:1rem;padding:7px 16px;border-radius:14px;font-weight:600;box-shadow:0 2px 8px #2193b050;">${p.tiempo_preparacion} min</span>
                                </div>
                                <button class="btn btn-primary w-100" style="font-weight:700;font-size:1.08rem;letter-spacing:1px;border-radius:14px;box-shadow:0 2px 8px #2193b050;" onclick="agregarAlCarrito(${p.id_producto}, '${p.nombre.replace(/'/g, "\\'")}', ${p.precio}, ${p.tiempo_preparacion}, '${p.nombre_evento}', '${p.fecha_evento}')">
                                    <i class="fas fa-cart-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        $('#listaProductos').html(html);
    });
}

function cargarEventos() {
    $.get('../ajax/pedido.php?op=listarTipos', function(data) {
        const eventos = JSON.parse(data);
        let html = '';

        if (eventos.length === 0) {
            html = '<p>No hay eventos disponibles.</p>';
        } else {
            eventos.forEach(evento => {
                html += `
                    <div class="evento-card" onclick="cargarProductos('${evento.nombre_evento}')">
                        <h4>${evento.nombre_evento}</h4>
                        <button class="btn btn-outline-primary btn-sm">
                            Ver productos
                        </button>
                    </div>
                `;
            });
        }

        $('#listaEventos').html(html);

        if (eventos.length > 0) {
            cargarProductos(eventos[0].nombre_evento);
        } else {
            $('#listaProductos').html('<p>No hay productos para mostrar.</p>');
        }
    });
}

function agregarAlCarrito(id_producto, nombre, precio, tiempo_preparacion, nombre_evento, fecha_evento) {
    if (!id_cliente) {
        Swal.fire('¡Inicia sesión!', 'Debes iniciar sesión para agregar productos.', 'warning');
        return;
    }

    const item = carrito.find(p => p.id_producto === id_producto);
    if (item) {
        item.cantidad++;
    } else {
        carrito.push({
            id_producto,
            nombre,
            cantidad: 1,
            precio,
            tiempo_preparacion: nombre_evento.toLowerCase() !== 'normal' ? 0 : tiempo_preparacion,
            nombre_evento: nombre_evento.toLowerCase(),
            fecha_evento
        });
    }
    mostrarCarrito();
}


function mostrarCarrito() {
    let html = '';
    carrito.forEach((item, index) => {
        html += `<tr>
            <td>${item.nombre}</td>
            <td>
                <input type="number" min="1" value="${item.cantidad}" onchange="actualizarCantidad(${index}, this.value)" class="form-control form-control-sm">
            </td>
        </tr>`;
    });
    $('#tablaCarrito tbody').html(html);
}

function actualizarCantidad(index, nuevaCantidad) {
    const cantidad = parseInt(nuevaCantidad);
    if (cantidad > 0) {
        carrito[index].cantidad = cantidad;
        mostrarCarrito();
    } else {
        Swal.fire('Cantidad inválida', 'Debe ser mayor a 0.', 'error');
    }
}

function enviarPedido() {
    if (carrito.length === 0) {
        Swal.fire('Carrito vacío', 'Agrega productos antes de realizar el pedido.', 'warning');
        return;
    }

    const tieneEspecial = carrito.some(item => item.nombre_evento !== 'normal');

    if (tieneEspecial) {
        Swal.fire({
            title: 'Hora de entrega',
            input: 'time',
            inputLabel: 'Selecciona la hora en que deseas que se entregue',
            inputAttributes: {
                step: 300
            },
            showCancelButton: true,
        }).then((resHora) => {
            if (resHora.isConfirmed) {
                enviarPedidoConDatos('especial', resHora.value);
            }
        });
    } else {
        enviarPedidoConDatos('normal', null);
    }
}

function enviarPedidoConDatos(tipo_pedido, hora_entrega) {
    Swal.fire({
        title: 'Ubicación del pedido',
        text: "¿Deseas usar tu ubicación actual o la guardada?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Usar actual',
        cancelButtonText: 'Usar guardada'
    }).then((result) => {
        if (result.isConfirmed) {
            obtenerUbicacionActual(function(lat, lon) {
                localStorage.setItem(keyUbicacion, JSON.stringify({ latitud: lat, longitud: lon }));
                pedirUbicacionExtraYEnviar(lat, lon, tipo_pedido, hora_entrega);
            });
        } else {
            const almacenada = localStorage.getItem(keyUbicacion);
            if (almacenada) {
                const ubicacion = JSON.parse(almacenada);
                pedirUbicacionExtraYEnviar(ubicacion.latitud, ubicacion.longitud, tipo_pedido, hora_entrega);
            } else {
                Swal.fire('Sin ubicación', 'No hay ubicación previa guardada.', 'error');
            }
        }
    });
}

function pedirUbicacionExtraYEnviar(latitud, longitud, tipo_pedido, hora_entrega) {
    Swal.fire({
        title: 'Ingrese ubicación extra',
        input: 'text',
        inputLabel: 'Por favor, escriba una ubicación adicional o indicaciones',
        inputPlaceholder: 'Ejemplo: Cerca de la entrada principal',
        showCancelButton: true,
    }).then((result) => {
        if (result.isConfirmed) {
            const ubicacionExtra = result.value || '';
            confirmarYGuardarPedido(latitud, longitud, tipo_pedido, hora_entrega, ubicacionExtra);
        }
    });
}

function confirmarYGuardarPedido(latitud, longitud, tipo_pedido, hora_entrega, ubicacionExtra) {
    let html = '<div style="text-align:left">';
    let total = 0;
    let tiemposPreparacion = [];

    carrito.forEach(item => {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;

        if (tipo_pedido === 'normal') {
            tiemposPreparacion.push(item.tiempo_preparacion);
            html += `<p><strong>${item.nombre}</strong> x${item.cantidad} = $${subtotal.toFixed(2)} <span class="text-muted">(${item.tiempo_preparacion} min)</span></p>`;
        } else {
            html += `<p><strong>${item.nombre}</strong> x${item.cantidad} = $${subtotal.toFixed(2)}</p>`;
            if (item.fecha_evento) {
                html += `<p><strong>📅 Fecha evento:</strong> ${item.fecha_evento}</p>`;
            }
        }
    });

    html += `<hr><p><strong>💵 Total:</strong> $${total.toFixed(2)}</p>`;

    if (tipo_pedido === 'normal') {
        const tiempoEstimado = Math.max(...tiemposPreparacion);
        html += `<p><strong>🕐 Tiempo estimado de preparacion:</strong> ${tiempoEstimado} minutos</p>`;
    }

    if (tipo_pedido === 'especial' && hora_entrega) {
        html += `<p><strong>⏰ Hora entrega:</strong> ${hora_entrega}</p>`;
    }

    html += '</div>';

    Swal.fire({
        title: 'Confirma tu pedido',
        html: html,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Confirmar pedido',
        cancelButtonText: 'Cancelar pedido',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            guardarPedido(latitud, longitud, tipo_pedido, hora_entrega, ubicacionExtra);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            carrito = [];
            mostrarCarrito();
            Swal.fire('Pedido cancelado', 'El pedido fue cancelado y el carrito se ha vaciado.', 'info').then(() => {
                cargarEventos();
            });
        }
    });
}

function guardarPedido(latitud, longitud, tipo_pedido, hora_entrega, ubicacionExtra = '') {
    $.post('../ajax/pedido.php?op=guardarPedido', {
        id_cliente: id_cliente,
        latitud: latitud,
        longitud: longitud,
        carrito: JSON.stringify(carrito),
        tipo_pedido: tipo_pedido,
        hora_entrega: hora_entrega,
        ubicacion_extra: ubicacionExtra
    }, function(response) {
        const res = JSON.parse(response);
        if (res.status === 'success') {
            carrito = [];
            mostrarCarrito();
            cargarEventos();
            Swal.fire('Pedido guardado', 'Tu pedido está siendo preparado. ¡Gracias!', 'success');
        } else {
            Swal.fire('Error', res.msg, 'error');
        }
    });
}

function obtenerUbicacionActual(callback) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            localStorage.setItem(keyUbicacion, JSON.stringify({ latitud: lat, longitud: lon }));
            callback(lat, lon);
        }, function(error) {
            Swal.fire('Error', 'No se pudo obtener la ubicación actual.', 'error');
            console.log("Error de ubicación:", error);
        }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    } else {
        Swal.fire('Error', 'Geolocalización no soportada.', 'error');
    }
}

$(document).ready(() => {
    // Cambié cargarTipos() por cargarEventos() para mostrar eventos directamente
    cargarEventos();
});
