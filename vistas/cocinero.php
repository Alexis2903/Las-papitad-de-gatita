<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cocinero') {
    header("Location: logeo.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Panel Cocinero - Comida Rápida</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
body.fullscreen-iframe .content-wrapper {
  margin: 0 !important;
  padding: 0 !important;
  border-radius: 0 !important;
  min-height: 100vh !important;
  box-shadow: none !important;
  background: #fff !important;
  animation: none !important;
}
body.fullscreen-iframe iframe {
  height: 100vh !important;
  min-height: 100vh !important;
  border-radius: 0 !important;
  box-shadow: none !important;
  background: #fff !important;
}
:root {
  --azul-principal: #357ABD;
  --azul-oscuro: #2a5e91;
  --azul-claro: #6dd5ed;
  --blanco: #fff;
  --gris-fondo: #f9fafb;
  --sombra-suave: rgba(53, 122, 189, 0.15);
  --glass-blur: blur(14px);
  --glass-shadow: 0 8px 32px 0 rgba(53,122,189,0.18);
}

body {
  font-family: 'Nunito', 'Rubik', sans-serif;
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
body.fullscreen-iframe::before,
body.fullscreen-iframe::after {
  opacity: 0 !important;
  pointer-events: none;
}

.main-header.navbar {
  background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%);
  backdrop-filter: var(--glass-blur);
  box-shadow: var(--glass-shadow);
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
}

.main-sidebar {
  background: rgba(255,255,255,0.92);
  border-right: 2px solid #6dd5ed;
  box-shadow: var(--glass-shadow);
  backdrop-filter: var(--glass-blur);
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
}
.brand-link img {
  height: 54px;
  margin-right: 10px;
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
.sidebar .nav-link .nav-icon {
  font-size: 1.5rem;
  color: #2193b0;
  transition: color 0.3s, transform 0.3s;
}
.sidebar .nav-link:hover,
.sidebar .nav-link.active {
  background: linear-gradient(90deg, #2193b0 0%, #6dd5ed 100%);
  color: #fff;
  font-weight: bold;
  box-shadow: 0 4px 18px #2193b040;
  transform: scale(1.04);
}
.sidebar .nav-link:hover .nav-icon,
.sidebar .nav-link.active .nav-icon {
  color: #fff;
  transform: scale(1.18) rotate(-8deg);
  text-shadow: 0 2px 8px #6dd5ed80;
}

.content-wrapper {
  background: rgba(255,255,255,0.92);
  margin: 28px 18px 18px 18px;
  border-radius: 28px;
  padding: 38px 28px;
  box-shadow: var(--glass-shadow);
  backdrop-filter: var(--glass-blur);
  position: relative;
  z-index: 1;
  min-height: 70vh;
  animation: fadeIn 1.1s;
}

iframe {
  width: 100%;
  height: 74vh;
  border: none;
  border-radius: 18px;
  background: rgba(255,255,255,0.98);
  box-shadow: 0 2px 12px #2193b030;
  transition: box-shadow 0.3s;
}
iframe:hover {
  box-shadow: 0 6px 24px #6dd5ed60;
}

.navbar-nav .nav-link {
  color: #fff !important;
  font-weight: 700;
  font-size: 1.12rem;
  letter-spacing: 0.5px;
  transition: color 0.3s;
}
.navbar-nav .nav-link:hover {
  color: #6dd5ed !important;
  text-shadow: 0 2px 8px #6dd5ed80;
}

.dropdown-menu {
  background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%);
  border-radius: 14px;
  box-shadow: 0 2px 12px #2193b030;
  border: none;
  padding: 10px 0;
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

#notificacionContador {
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
}
#listaNotificaciones.dropdown-menu {
  background-color: #ffffff !important;
  color: #212529 !important;
  border: 1px solid #dee2e6;
  box-shadow: 0 4px 18px rgba(53,122,189,0.18);
  min-width: 380px;
  max-width: 480px;
  width: 100%;
  left: -220px !important;
  right: auto !important;
  padding: 18px 0 18px 0;
  max-height: 480px !important;
  overflow-y: auto !important;
  border-radius: 18px;
  backdrop-filter: blur(8px);
}
#listaNotificaciones .dropdown-item {
  display: block;
  width: 100%;
  background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);
  box-shadow: 0 2px 12px rgba(53,122,189,0.10);
  border-radius: 12px;
  margin: 6px 10px;
  padding: 14px 18px;
  font-size: 1.08rem;
  font-weight: 500;
  color: #2193b0 !important;
  border: none;
  position: relative;
  transition: background 0.3s, color 0.3s, box-shadow 0.3s;
  backdrop-filter: blur(6px);
  white-space: normal;
  word-break: break-word;
  overflow-wrap: anywhere;
}
#listaNotificaciones .dropdown-item:hover {
  background: linear-gradient(90deg, #6dd5ed 0%, #2193b0 100%);
  color: #fff !important;
  box-shadow: 0 4px 18px #2193b040;
  font-weight: bold;
}
#listaNotificaciones .noti-icon {
  font-size: 1.5rem;
  color: #357ABD;
  background: #fff;
  border-radius: 50%;
  box-shadow: 0 2px 8px #2193b020;
  padding: 6px;
  margin-right: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
}
#listaNotificaciones .noti-text {
  display: block;
  width: 100%;
  word-break: break-word;
  line-height: 1.3;
  white-space: normal;
  overflow-wrap: anywhere;
}
#listaNotificaciones .dropdown-header {
  color: #fff !important;
  font-size: 1rem;
  text-align: center;
  padding: 12px 0;
  display: block;
  background: none !important;
  border: none !important;
}

/* Responsive */
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
  }
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

    <ul class="navbar-nav ml-auto align-items-center">
      <li class="nav-item dropdown">
<a class="nav-link" data-bs-toggle="dropdown" href="#" id="notificacionesDropdown" role="button">
          <i class="fas fa-bell"></i>
          <span class="badge badge-danger navbar-badge" id="notificacionContador" style="display: none;">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="listaNotificaciones" style="max-height: 300px; overflow-y: auto;">
          <span class="dropdown-header">No hay notificaciones</span>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button"><i class="fas fa-expand-arrows-alt"></i></a>
      </li>

      <!-- Dropdown usuario -->
      <li class="nav-item dropdown">
<a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="perfilDropdown" data-bs-toggle="dropdown" style="cursor:pointer;">
          <i class="fas fa-user-circle fa-lg mr-2"></i>
          <span>Cocinero</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="perfilDropdown">
<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPerfil">
            <i class="fas fa-user mr-2"></i> Perfil
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="cerrar_sesion.php">
            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
          </a>
        </div>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar elevation-4">
    <a href="#" class="brand-link">
      <img src="dist/img/comidarapida.png" alt="Logo" class="brand-image img-circle elevation-3" />
      <span class="brand-text">Cocinero</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="cargarPagina('PedidosCocinero.php')">
              <i class="fas fa-hamburger nav-icon"></i>
              <p>Preparación de pedidos</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Contenido -->
  <div class="content-wrapper" id="contenido-dinamico">
    <iframe src="../vistas/Inicio.php" frameborder="0" id="iframe-contenido"></iframe>
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

<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<script>
function ajustarAlturaIframe() {
  const iframe = document.getElementById('iframe-contenido');
  const footer = document.getElementById('mi-footer');
  const windowHeight = window.innerHeight;
  const navbarHeight = document.querySelector('.main-header').offsetHeight;
  const footerVisible = footer.style.display !== 'none';
  const margen = 60;
  iframe.style.height = (windowHeight - navbarHeight - (footerVisible ? footer.offsetHeight : 0) - margen) + 'px';
}

function cargarPagina(pagina) {
  const iframe = document.getElementById('iframe-contenido');
  const footer = document.getElementById('mi-footer');
  iframe.src = pagina;
  if (pagina === '../vistas/Inicio.php') {
    footer.style.display = 'block';
    document.body.classList.remove('fullscreen-iframe');
  } else {
    footer.style.display = 'none';
    document.body.classList.add('fullscreen-iframe');
  }
  setTimeout(ajustarAlturaIframe, 100);
}

window.onload = () => {
  document.getElementById('mi-footer').style.display = 'block';
  ajustarAlturaIframe();
};
window.onresize = ajustarAlturaIframe;

function actualizarNotificaciones() {
  $.get('../ajax/notificacion_pedidos.php', function(response) {
    const res = JSON.parse(response);
    const contador = $('#notificacionContador');
    const lista = $('#listaNotificaciones');

    if (res.status === 'success') {
      if (res.nuevos > 0) {
        contador.text(res.nuevos).show();
        lista.html(`<span class="dropdown-header">${res.nuevos} pedido(s) nuevo(s)</span>`);

        res.pedidos.forEach(pedido => {
          let productosHTML = '<ul style="padding-left: 18px; margin: 5px 0;">';
          pedido.productos.forEach(producto => {
            productosHTML += `
              <li>
                ${producto.cantidad} x ${producto.nombre} - $${producto.precio_unitario.toFixed(2)} c/u 
                <strong>Total: $${producto.total_producto.toFixed(2)}</strong>
              </li>`;
          });
          productosHTML += '</ul>';

          lista.append(`
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" onclick="cargarPagina('PedidosCocinero.php')">
              <span class="noti-icon"><i class="fas fa-utensils"></i></span>
              <div>
                <span class="noti-text"><strong>${pedido.nombre_cliente}</strong> ha solicitado un pedido (${pedido.eventos}) - ${pedido.tiempo_estimado_preparacion} min</span>
                ${productosHTML}
              </div>
              <span class="float-right text-muted text-sm" style="margin-left:auto;">${pedido.hora}</span>
            </a>`);
        });

        lista.append(`<div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer" onclick="cargarPagina('PedidosCocinero.php')">Ver todos los pedidos</a>`);
      } else {
        contador.hide();
        lista.html('<span class="dropdown-header">No hay notificaciones</span>');
      }
    }
  });
}

setInterval(actualizarNotificaciones, 5000);
actualizarNotificaciones();

</script>
</body>
</html>
