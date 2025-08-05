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
    /* Estilos modernos para notificaciones */
    #contadorNotificaciones {
      position: absolute;
      top: 6px;
      right: 6px;
      background: #f13636ff;
      color: #fff;
      font-size: 0.75rem;
      padding: 2px 6px;
      border-radius: 50%;
      display: none;
      font-weight: bold;
      min-width: 18px;
      text-align: center;
      line-height: 1;
      box-shadow: 0 2px 8px #2193b040;
      z-index: 1100;
    }
    #listaNotificaciones.dropdown-menu {
      background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%) !important;
      color: #212529 !important;
      border: none;
      box-shadow: 0 8px 32px 0 rgba(53,122,189,0.18);
      min-width: 320px;
      max-width: 380px;
      width: 100%;
      left: auto !important;
      right: 32px !important;
      top: 80px !important;
      transform: none !important;
      padding: 16px 0;
      max-height: 420px !important;
      overflow-y: auto !important;
      border-radius: 18px 0 0 18px;
      backdrop-filter: blur(14px);
      position: fixed !important;
      z-index: 1060 !important;
    }
    #listaNotificaciones .dropdown-item {
      display: flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);
      box-shadow: 0 2px 8px rgba(53,122,189,0.08);
      border-radius: 10px;
      margin: 4px 8px;
      padding: 8px 12px;
      font-size: 0.98rem;
      font-weight: 500;
      color: #2193b0 !important;
      border: none;
      position: relative;
      transition: background 0.3s, color 0.3s, box-shadow 0.3s;
      backdrop-filter: blur(6px);
      white-space: normal;
      word-break: break-word;
      overflow-wrap: anywhere;
      cursor: default;
    }
    #listaNotificaciones .dropdown-item:hover {
      background: linear-gradient(90deg, #6dd5ed 0%, #2193b0 100%);
      color: #fff !important;
      box-shadow: 0 4px 18px #2193b040;
      font-weight: bold;
    }
    #listaNotificaciones .noti-icon {
      font-size: 1.15rem;
      color: #357ABD;
      background: #fff;
      border-radius: 50%;
      box-shadow: 0 2px 6px #2193b020;
      padding: 4px;
      margin-right: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    #listaNotificaciones .noti-text {
      flex: 1;
      word-break: break-word;
      line-height: 1.3;
      white-space: normal;
      overflow-wrap: anywhere;
    }

    :root {
      --color-primario: #0a192f;
      --color-secundario: #1e2a3a;
      --acento: #64ffda;
      --texto-claro: #f8f8f8;
      --fondo-transparente: rgba(10, 25, 47, 0.9);
    }

    body {
      font-family: 'Rubik', sans-serif;
      min-height: 100vh;
      background: linear-gradient(135deg, #6dd5ed 0%, #2193b0 100%);
      color: #34495e;
      position: relative;
      overflow-x: hidden;
    }
    body::before {
      content: '';
      position: absolute;
      top: -120px; left: -120px;
      width: 340px; height: 340px;
      background: radial-gradient(circle, #2193b0 60%, #6dd5ed 100%);
      opacity: 0.18;
      border-radius: 50%;
      z-index: 0;
      transition: opacity 0.3s;
    }
    body::after {
      content: '';
      position: absolute;
      bottom: -100px; right: -100px;
      width: 260px; height: 260px;
      background: radial-gradient(circle, #6dd5ed 60%, #2193b0 100%);
      opacity: 0.15;
      border-radius: 50%;
      z-index: 0;
      transition: opacity 0.3s;
    }

    .main-header.navbar {
      background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%);
      backdrop-filter: blur(14px);
      box-shadow: 0 8px 32px 0 rgba(53,122,189,0.18);
      border: none;
      border-radius: 0 0 18px 18px;
      z-index: 2;
    }

    .main-footer {
      background: rgba(255,255,255,0.92);
      color: #357ABD;
      text-align: center;
      font-size: 1.05rem;
      border-top: 2px solid #6dd5ed;
      box-shadow: 0 -2px 12px #2193b030;
      border-radius: 12px 12px 0 0;
      margin: 0 18px 18px 18px;
      font-weight: 700;
      transition: opacity 0.3s;
    }

    .main-sidebar {
      background: rgba(255,255,255,0.92);
      border-right: 2px solid #6dd5ed;
      box-shadow: 0 8px 32px 0 rgba(53,122,189,0.18);
      backdrop-filter: blur(14px);
      border-radius: 0 18px 18px 0;
      z-index: 2;
      min-width: 80px;
      width: 240px;
      max-width: 320px;
      transition: width 0.3s;
    }

    .brand-link {
      background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%);
      text-align: center;
      font-weight: bold;
      color: #fff;
      font-size: 1.2rem;
      letter-spacing: 1px;
      border-radius: 0 0 12px 12px;
      box-shadow: 0 2px 8px #2193b020;
      text-shadow: 0 2px 8px #2193b080;
      padding: 12px 0 8px 0;
      word-break: break-word;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
    }

    .brand-link img {
      height: 54px;
      filter: drop-shadow(0 2px 8px #6dd5ed80);
    }

    .sidebar .nav-link {
      color: #357ABD;
      background: rgba(255,255,255,0.98);
      transition: 0.3s;
      border-radius: 12px;
      margin-bottom: 10px;
      font-size: 1.12rem;
      padding: 14px 22px;
      font-weight: 700;
      box-shadow: 0 2px 8px #6dd5ed20;
      display: flex;
      align-items: center;
      gap: 12px;
      position: relative;
      overflow: hidden;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background: linear-gradient(90deg, #2193b0 0%, #6dd5ed 100%);
      color: #fff;
      font-weight: bold;
      box-shadow: 0 4px 18px #2193b040;
      transform: scale(1.04);
    }

    /* Aquí agregamos estilos para el layout con iframe a la derecha */
    .content-wrapper {
      background: rgba(255,255,255,0.92);
      margin: 28px 18px 18px 18px;
      border-radius: 28px;
      padding: 38px 28px;
      box-shadow: 0 8px 32px 0 rgba(53,122,189,0.18);
      backdrop-filter: blur(14px);
      position: relative;
      z-index: 1;
      min-height: 70vh;
      animation: fadeIn 1.1s;
      transition: all 0.3s ease;
      /* Para diseño normal */
      display: block;
    }
    .content-wrapper.layout-iframe-derecha {
      display: flex;
      margin: 28px 18px 18px 18px;
      padding: 0;
      border-radius: 0;
      background: none;
      box-shadow: none;
      height: calc(100vh - 56px); /* ajusta según navbar */
    }

    iframe {
      width: 100%;
      height: 74vh;
      border: none;
      border-radius: 18px;
      background: rgba(255,255,255,0.98);
      box-shadow: 0 2px 12px #2193b030;
      transition: box-shadow 0.3s, width 0.3s, height 0.3s;
      display: block;
    }

    /* Cuando esté con layout de iframe derecha */
    .content-wrapper.layout-iframe-derecha iframe {
      width: 100%;
      height: 100%;
      border-radius: 0;
      box-shadow: none;
    }

    iframe:hover {
      box-shadow: 0 6px 24px #6dd5ed60;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @media (max-width: 768px) {
      .content-wrapper {
        margin: 12px 2px;
        padding: 12px 2px;
        border-radius: 12px;
      }
      .main-footer {
        margin: 0 2px 2px 2px;
        border-radius: 8px 8px 0 0;
      }
      .main-sidebar {
        border-radius: 0 8px 8px 0;
      }
      .brand-link {
        font-size: 1.2rem;
        border-radius: 0 0 8px 8px;
      }
      iframe {
        border-radius: 8px;
        height: 60vh;
      }
      /* En móvil deshabilitamos layout a la derecha para no romper diseño */
      .content-wrapper.layout-iframe-derecha {
        display: block;
        height: auto;
        margin: 12px 2px;
        padding: 12px 2px;
        border-radius: 12px;
      }
      .content-wrapper.layout-iframe-derecha iframe {
        height: 60vh;
        border-radius: 8px;
        box-shadow: 0 2px 12px #2193b030;
      }
    }

    .navbar-nav .nav-link {
      color: var(--texto-claro) !important;
      font-weight: 500;
    }

    .navbar-nav .nav-link:hover {
      color: var(--acento) !important;
    }

    .dropdown-menu {
      background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%);
      border-radius: 14px;
      box-shadow: 0 2px 12px #2193b030;
      border: none;
      padding: 10px 0;
      z-index: 1051 !important;
    }

    .dropdown-item {
      color: #fff;
      font-size: 1.08rem;
      border-radius: 10px;
      padding: 12px 22px;
      transition: background 0.3s, color 0.3s;
    }

    .dropdown-item:hover {
      background: linear-gradient(90deg, #6dd5ed 0%, #2193b0 100%);
      color: #2193b0;
      font-weight: bold;
      box-shadow: 0 2px 12px #6dd5ed40;
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
          notificacionesPedido.push(`El pedido que realizó el ${n.fecha_pedido} está en camino. El repartidor ${n.nombre_repartidor} ${n.apellido_repartidor} llegará aproximadamente a las ${horaLlegada}.`);

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
