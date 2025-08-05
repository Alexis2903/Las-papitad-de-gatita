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
    
    /* 3. Estilo del Contenido y del Iframe (sin dictar altura fija) */
    .content-wrapper {
      background: transparent;
      padding: 1rem;
      transition: all 0.3s ease;
      border-top: none;
    }
    iframe {
      width: 100%;
      /* LA ALTURA AHORA LA CONTROLA EL JAVASCRIPT, COMO EN TU PÁGINA DE CLIENTE */
      border: none;
      border-radius: 12px;
      box-shadow: var(--sombra-caja);
      background-color: var(--blanco-puro);
    }
    
    /* 4. Estilos para la Plantilla Principal */
    .main-header.navbar, .main-sidebar, .main-footer {
      background: var(--blanco-puro) !important;
      border-color: var(--borde-suave) !important;
      box-shadow: none !important;
      backdrop-filter: none;
    }
    .brand-link { background: var(--blanco-puro) !important; border-bottom: 1px solid var(--borde-suave); }
    .brand-link .brand-text { color: var(--azul-resaltado) !important; font-weight: 700; text-shadow: none; }
    .main-header .nav-link { color: var(--texto-secundario) !important; font-weight: 500; text-shadow: none; }
    .main-header .nav-link:hover { color: var(--azul-resaltado) !important; }

    /* 5. Menú Lateral con Efectos Modernos */
    .sidebar .nav-link {
      color: var(--azul-resaltado); background: transparent; border-radius: 8px;
      margin: 4px 10px; font-weight: 500; position: relative; box-shadow: none;
      transition: transform var(--duracion-transicion) ease, background-color var(--duracion-transicion) ease;
    }
    .sidebar .nav-link .nav-icon {
      font-size: 1.1rem; color: var(--azul-resaltado);
      transition: transform var(--duracion-transicion) ease, color var(--duracion-transicion) ease;
    }
    .sidebar .nav-link:hover { background-color: rgba(13, 110, 253, 0.08); transform: translateX(5px); }
    .sidebar .nav-link:hover .nav-icon { transform: scale(1.1) rotate(-5deg); }
    .sidebar .nav-link.active {
      background: var(--azul-resaltado); color: var(--blanco-puro) !important;
      box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4); transform: translateX(5px) scale(1.02);
    }
    .sidebar .nav-link.active p, .sidebar .nav-link.active .nav-icon { color: var(--blanco-puro) !important; transform: none; }
    .sidebar .nav-link.active::before {
      content: ''; position: absolute; left: -10px; top: 50%;
      transform: translateY(-50%); height: 70%; width: 4px;
      background-color: var(--azul-resaltado); border-radius: 4px;
    }
    
    /* 6. Diseño Moderno para Notificaciones */
    #notificacionContador {
      top: 8px !important; right: 0 !important; height: 18px; width: 18px;
      background: var(--rojo-notificacion); border: 2px solid var(--blanco-puro);
    }
    .dropdown-menu {
      background: var(--blanco-puro) !important; box-shadow: var(--sombra-caja) !important;
      border: 1px solid var(--borde-suave) !important; border-radius: .75rem !important; padding: .5rem !important;
    }
    #listaNotificaciones.dropdown-menu { min-width: 380px; max-width: 480px; max-height: 480px !important; overflow-y: auto !important; }
    #listaNotificaciones .dropdown-item {
      white-space: normal; background: transparent !important; color: var(--texto-oscuro) !important;
      padding: .75rem 1rem !important; transition: background-color var(--duracion-transicion) ease; box-shadow: none;
    }
    #listaNotificaciones .dropdown-item:hover { background: rgba(13, 110, 253, 0.08) !important; font-weight: 500; }
    #listaNotificaciones .noti-icon { color: var(--azul-resaltado); font-size: 1.2rem; margin-right: 0.5rem; background: none; box-shadow: none; }
    .dropdown-header { color: var(--texto-secundario) !important; font-size: 0.9rem; background: none !important; }
    .dropdown-item.dropdown-footer { text-align: center; font-weight: bold; color: var(--azul-resaltado) !important; }
    .main-footer { color: var(--texto-secundario); font-weight: 500; border-top-color: var(--borde-suave); }
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
    // USANDO LA LÓGICA DE TU PÁGINA DE CLIENTE QUE SÍ FUNCIONA
    function ajustarAlturaIframe() {
      const iframe = document.getElementById('iframe-contenido');
      if (!iframe) return; // Si no hay iframe, no hacer nada

      const footer = document.getElementById('mi-footer');
      const windowHeight = window.innerHeight;
      const navbarHeight = document.querySelector('.main-header').offsetHeight;
      const footerHeight = footer.style.display !== 'none' ? footer.offsetHeight : 0;
      
      // La altura se calcula restando la barra de navegación y el footer (si está visible)
      // Se resta un pequeño margen para dar espacio
      const margen = 40; 
      iframe.style.height = (windowHeight - navbarHeight - footerHeight - margen) + 'px';
    }

    function cargarPagina(pagina) {
      const iframe = document.getElementById('iframe-contenido');
      const footer = document.getElementById('mi-footer');
      iframe.src = pagina;
      
      // La misma lógica de tu página de cliente, pero para el cocinero
      // Si la página NO es 'Inicio', se considera pantalla completa
      if (!pagina.includes('Inicio.php')) {
        footer.style.display = 'none';
        document.body.classList.add('fullscreen-iframe'); // Usamos tu clase original
      } else {
        footer.style.display = 'block';
        document.body.classList.remove('fullscreen-iframe');
      }

      // Esperamos un momento para que el DOM se actualice (footer oculto/visible)
      // y LUEGO calculamos la altura. Esto es clave.
      setTimeout(ajustarAlturaIframe, 100);
    }
    
    // Llamamos a la función al cargar y al cambiar el tamaño de la ventana
    window.onload = () => {
      // Cargamos la página de inicio por defecto y ajustamos
      cargarPagina('../vistas/Inicio.php');
    };
    window.onresize = ajustarAlturaIframe;

    // Tu lógica de notificaciones se mantiene intacta.
    function actualizarNotificaciones() {
      $.get('../ajax/notificacion_pedidos.php', function(response) {
        // ... (tu código de notificaciones queda aquí, no se toca)
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
                  <div class="d-flex align-items-start">
                    <span class="noti-icon pt-1"><i class="fas fa-utensils"></i></span>
                    <div class="flex-grow-1">
                      <span class="noti-text"><strong>${pedido.nombre_cliente}</strong> ha solicitado un pedido (${pedido.eventos}) - ${pedido.tiempo_estimado_preparacion} min</span>
                      ${productosHTML}
                    </div>
                    <span class="text-muted text-sm ms-auto">${pedido.hora}</span>
                  </div>
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
