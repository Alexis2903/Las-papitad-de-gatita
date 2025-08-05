<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../vistas/logeo.php');
    exit;
}
$id_cliente = $_SESSION['id_usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestión del Sistema - Comida Rápida</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;700&display=swap" rel="stylesheet" />
  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="plugins/bootstrap-5.3.7/css/bootstrap.min.css" />
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />

  <style>
    /* 1. Paleta de Colores y Variables de Diseño Moderno */
    :root {
      --azul-resaltado: #0d6efd;
      --blanco-puro: #ffffff;
      --fondo-principal: #f4f6f9;
      --borde-suave: #dee2e6;
      --sombra-caja: 0 6px 18px rgba(0, 0, 0, 0.08);
      --texto-oscuro: #343a40;
      --texto-secundario: #6c757d;
      --rojo-notificacion: #dc3545;
      --duracion-transicion: 0.25s;
    }

    /* 2. Estilos Base */
    body {
      font-family: 'Rubik', 'Nunito', sans-serif;
      background: var(--fondo-principal) !important;
      color: var(--texto-oscuro);
      overflow-x: hidden;
    }
    
    /* 3. Estilo del Contenido y del Iframe (sin tocar el layout) */
    .content-wrapper {
      background: transparent; /* El contenedor es un espacio transparente */
      padding: 1rem;
      transition: all 0.3s ease;
    }
    iframe {
      width: 100%;
      height: 100%; /* El JS se encarga de la altura, esto solo hace que el iframe llene el espacio dado */
      border: none;
      border-radius: 12px; /* Redondeo profesional */
      box-shadow: var(--sombra-caja);
      background-color: var(--blanco-puro);
    }
    
    /* 4. Estilos para la Plantilla Principal */
    .main-header.navbar, .main-sidebar, .main-footer {
      background: var(--blanco-puro);
      border-color: var(--borde-suave);
      box-shadow: none; /* Look más plano y moderno */
    }

    /* Título de la marca */
    .brand-link { border-bottom: 1px solid var(--borde-suave); }
    .brand-link .brand-text { color: var(--azul-resaltado) !important; font-weight: 700; }
    .brand-link img { height: 38px; }

    /* Barra de navegación superior */
    .main-header .nav-link { color: var(--texto-secundario) !important; font-weight: 500; }
    .main-header .nav-link:hover { color: var(--azul-resaltado) !important; }

    /* 5. Menú Lateral con Efectos Modernos */
    .sidebar .nav-link {
      color: var(--azul-resaltado);
      border-radius: 8px;
      margin: 4px 10px;
      font-weight: 500;
      position: relative;
      transition: transform var(--duracion-transicion) ease, background-color var(--duracion-transicion) ease;
    }
    .sidebar .nav-link .nav-icon {
      color: var(--azul-resaltado);
      transition: transform var(--duracion-transicion) ease, color var(--duracion-transicion) ease;
    }
    .sidebar .nav-link:hover {
      background-color: rgba(13, 110, 253, 0.08);
      transform: translateX(5px);
    }
    .sidebar .nav-link:hover .nav-icon { transform: scale(1.1) rotate(-5deg); }
    .sidebar .nav-link.active {
      background: var(--azul-resaltado);
      color: var(--blanco-puro) !important;
      box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4);
      transform: translateX(5px) scale(1.02);
    }
    .sidebar .nav-link.active p, .sidebar .nav-link.active .nav-icon {
      color: var(--blanco-puro) !important;
      transform: none;
    }
    .sidebar .nav-link.active::before {
      content: ''; position: absolute; left: -10px; top: 50%;
      transform: translateY(-50%); height: 70%; width: 4px;
      background-color: var(--azul-resaltado); border-radius: 4px;
    }
    
    /* 6. Nuevo Diseño para Notificaciones */
    #contadorNotificaciones {
      position: absolute; top: 8px; right: 0;
      height: 18px; width: 18px;
      background: var(--rojo-notificacion);
      color: var(--blanco-puro);
      font-size: 0.65rem;
      border-radius: 50%;
      display: none;
      font-weight: bold;
      line-height: 18px;
      text-align: center;
      border: 2px solid var(--blanco-puro); /* Borde blanco para destacar */
    }
    
    .dropdown-menu {
      background-color: var(--blanco-puro) !important;
      box-shadow: var(--sombra-caja) !important;
      border: 1px solid var(--borde-suave) !important;
      border-radius: .75rem !important;
    }
    
    #listaNotificaciones.dropdown-menu {
      min-width: 320px;
      max-height: 400px !important;
      overflow-y: auto !important;
      padding: .5rem !important;
    }

    #listaNotificaciones .dropdown-item {
      white-space: normal; /* Permite que el texto se divida en varias líneas */
      color: var(--texto-oscuro) !important;
      padding: .75rem 1rem !important;
      transition: background-color var(--duracion-transicion) ease;
      display: flex;
      gap: .75rem;
      align-items: flex-start;
    }
    #listaNotificaciones .dropdown-item:hover {
      background-color: rgba(13, 110, 253, 0.08) !important;
      color: var(--texto-oscuro) !important;
      font-weight: normal; /* Quitamos el bold del hover antiguo */
    }
    #listaNotificaciones .noti-icon {
      color: var(--azul-resaltado);
      font-size: 1rem;
      margin-top: 2px;
    }
    
    .main-footer {
      color: var(--texto-secundario);
    }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link" onclick="cargarPagina('../vistas/Inicio.php')">Inicio</a>
      </li>
    </ul>
    <ul class="navbar-nav ms-auto align-items-center">
      <li class="nav-item dropdown">
        <a class="nav-link position-relative" href="#" id="notificacionesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-bell"></i>
          <span id="contadorNotificaciones">0</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificacionesDropdown" id="listaNotificaciones">
          <li><span class="dropdown-item-text">No hay notificaciones</span></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="perfilDropdown" data-bs-toggle="dropdown" style="cursor:pointer;">
          <i class="fas fa-user-circle fa-lg me-2"></i>
          <span><?= htmlspecialchars($_SESSION['usuario'] ?? 'Cliente'); ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="perfilDropdown">
          <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPerfil">
            <i class="fas fa-user me-2"></i> Perfil
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="cerrar_sesion.php">
            <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
          </a>
        </div>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar elevation-4">
    <a href="#" class="brand-link">
      <img src="dist/img/comidarapida.png" alt="Logo" class="brand-image img-circle elevation-3" />
      <span class="brand-text">Clientes</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="cargarPagina('pedido.php')">
              <i class="fas fa-hamburger nav-icon"></i>
              <p>Realizar su Pedido</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Contenido -->
  <div class="content-wrapper" id="contenido-dinamico">
    <iframe src="../vistas/Inicio.php" frameborder="0" id="iframe-contenido" title="Contenido"></iframe>
  </div>

  <!-- Footer -->
  <footer class="main-footer" id="mi-footer">
    <strong>&copy; 2024 Comida Rápida.</strong> Todos los derechos reservados.
  </footer>
</div>

<!-- Modal Perfil -->
<div class="modal fade" id="modalPerfil" tabindex="-1" role="dialog" aria-labelledby="modalPerfilLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
    <div class="modal-content p-0">
      <div class="modal-header d-flex align-items-center justify-content-between">
        <span id="modalPerfilLabel"><i class="fas fa-user-circle fa-lg mr-2"></i> Perfil de Usuario</span>
        <button type="button" class="btn-close btn btn-sm btn-outline-light" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <iframe src="perfil.php" frameborder="0" style="width: 100%; height: 420px; border-radius: 0 0 18px 18px; overflow: hidden; background: rgba(255,255,255,0.98);"></iframe>
    </div>
  </div>
</div>

<div id="notificaciones" style="position: fixed; top: 20px; right: 20px; z-index: 1055;"></div>
<!-- Bootstrap 5 y jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>
  const idCliente = <?= json_encode($id_cliente); ?>;

  function ajustarAlturaIframe() {
    const iframe = document.getElementById('iframe-contenido');
    const footer = document.getElementById('mi-footer');
    const wrapper = document.getElementById('contenido-dinamico');
    const windowHeight = window.innerHeight;
    const navbarHeight = document.querySelector('.main-header').offsetHeight;

    // Si el iframe carga pedido.php, layout a la derecha y ocupa todo el alto y ancho posible
    if (iframe.src.indexOf('pedido.php') !== -1) {
      iframe.style.height = (windowHeight - navbarHeight) + 'px';
      footer.style.display = 'none';

      // Agregar clase para layout horizontal
      wrapper.classList.add('layout-iframe-derecha');
    } else {
      // Diseño normal, con footer visible y margins
      iframe.style.height = (windowHeight - navbarHeight - footer.offsetHeight - 60) + 'px';
      footer.style.display = 'block';

      // Quitar clase para layout horizontal
      wrapper.classList.remove('layout-iframe-derecha');
    }
  }

  function cargarPagina(pagina) {
    const iframe = document.getElementById('iframe-contenido');
    iframe.src = pagina;
    setTimeout(ajustarAlturaIframe, 100);
  }

  window.onload = () => {
    document.getElementById('mi-footer').style.display = 'block';
    ajustarAlturaIframe();
  };
  window.onresize = ajustarAlturaIframe;


  function mostrarNotificacion(mensaje) {
    const contenedor = $('#notificaciones');
    const noti = $(`<div class="toast" style="min-width:250px;margin-bottom:10px;background-color:#1976d2;color:white;padding:10px 20px;border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,0.2);position:relative;">${mensaje}<span class="cerrar-toast" style="position:absolute;top:5px;right:10px;font-weight:bold;cursor:pointer;">&times;</span></div>`);
    noti.find('.cerrar-toast').on('click', () => noti.hide());
    contenedor.append(noti);
  }

 function calcularHoraLlegada(horaSalida, horaDemora) {
  // Convertir hora_salida a Date
  const salida = new Date(horaSalida); // ejemplo: "2025-08-04 14:30:00"

  // Separar la horaDemora (ejemplo: "00:45:00")
  const partesDemora = horaDemora.split(':');
  const horas = parseInt(partesDemora[0]);
  const minutos = parseInt(partesDemora[1]);
  const segundos = parseInt(partesDemora[2]);

  // Sumar a la hora de salida
  salida.setHours(salida.getHours() + horas);
  salida.setMinutes(salida.getMinutes() + minutos);
  salida.setSeconds(salida.getSeconds() + segundos);

  // Formatear a HH:MM
  const hora = salida.getHours().toString().padStart(2, '0');
  const minuto = salida.getMinutes().toString().padStart(2, '0');

  return `${hora}:${minuto}`;
}
function actualizarNotificaciones() {
  $.getJSON("../ajax/cocinero.php?action=notificacionesCliente&id_cliente=" + idCliente, function(data) {
    const $contador = $('#contadorNotificaciones');
    const $lista = $('#listaNotificaciones');

    if (data.status === "success") {
      const notis = data.notificaciones;
      let nuevasNotis = 0;
      $lista.empty();

      const pedidosMostrados = new Set();

      notis.forEach(n => {
        if (pedidosMostrados.has(n.id_pedido)) {
          // Ya mostramos notificación para este pedido, saltar
          return;
        }

        let notificacionesPedido = [];

        // 1. Preparando
        if (n.estado === "Preparando") {
          notificacionesPedido.push(`El pedido que realizó el ${n.fecha_pedido} está siendo preparado.`);
        }

        // 2. En camino (solo mostrar esta con hora llegada)
        if (n.estado === "En camino") {
          const horaLlegada = calcularHoraLlegada(n.hora_salida, n.hora_demora);
          notificacionesPedido.push(`El pedido está en camino. El repartidor ${n.nombre_repartidor} ${n.apellido_repartidor} llegará aproximadamente a las ${horaLlegada}.`);

          // 3. Pago agregado (solo si hay pago)
          if (n.pago_viaje && parseFloat(n.pago_viaje) > 0) {
            notificacionesPedido.push(`El repartidor ${n.nombre_repartidor} ${n.apellido_repartidor} indicó que el valor a pagar es $${parseFloat(n.pago_viaje).toFixed(2)}.`);
          }
        }

        // 4. Entregado
        if (n.estado === "Entregado") {
          notificacionesPedido.push(`El pedido que realizó el ${n.fecha_pedido} fue entregado con éxito. ¡Gracias por su compra!`);
        }

        // Si hay notificaciones para este pedido, mostrarlas y marcar como mostrado
        if (notificacionesPedido.length > 0) {
          notificacionesPedido.forEach(mensaje => {
            const notiHtml = `
              <li>
                <a href="#" class="dropdown-item" onclick="marcarVisto(${n.id_pedido})">
                  <i class="fas fa-info-circle noti-icon"></i>
                  <span class="noti-text">${mensaje}</span>
                </a>
              </li>`;
            $lista.append(notiHtml);
            nuevasNotis++;
          });
          pedidosMostrados.add(n.id_pedido);
        }
      });

      if (nuevasNotis > 0) {
        $contador.text(nuevasNotis).show();
      } else {
        $contador.hide();
        $lista.html('<li><span class="dropdown-item-text">No hay notificaciones</span></li>');
      }
    }
  });
}


  actualizarNotificaciones();
  setInterval(actualizarNotificaciones, 30000);
</script>



</body>
</html>
