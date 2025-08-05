<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'repartidor') {
    header("Location: logeo.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Panel Repartidor</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />
  <link rel="stylesheet" href="plugins/bootstrap-5.3.7/css/bootstrap.min.css">

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
      --duracion-transicion: 0.25s;
    }

    /* 2. Estilos Base */
    body {
      font-family: 'Rubik', 'Nunito', sans-serif;
      background: var(--fondo-principal) !important;
      color: var(--texto-oscuro);
    }

    /* 3. Estilo del Contenido y del Iframe */
    .content-wrapper {
      background: transparent;
      padding: 1rem;
      transition: all 0.3s ease;
      border-top: none;
      display: block;
    }
    iframe {
      width: 100%;
      height: 100%;
      border: none;
      border-radius: 12px;
      box-shadow: var(--sombra-caja);
      background-color: var(--blanco-puro);
    }
    
    /* 4. Lógica de layout replicada */
    .content-wrapper.layout-iframe-derecha {
      display: flex;
      padding: 0;
      margin: 0;
    }
    .layout-iframe-derecha > iframe {
      flex: 1;
      border-radius: 0;
      box-shadow: none;
    }
    
    /* 5. Estilos para la Plantilla Principal */
    .main-header.navbar, .main-sidebar, .main-footer {
      background: var(--blanco-puro) !important;
      border-color: var(--borde-suave) !important;
      box-shadow: none !important;
      backdrop-filter: none;
    }
    
    /* ¡AQUÍ ESTÁ LA CORRECCIÓN! */
    .brand-link { 
      background: var(--blanco-puro) !important; 
      border-bottom: none; /* Se ha quitado la línea inferior */
    }
    
    .brand-link .brand-text { color: var(--azul-resaltado) !important; font-weight: 700; text-shadow: none; }
    .main-header .nav-link { color: var(--texto-secundario) !important; font-weight: 500; text-shadow: none; }
    .main-header .nav-link:hover { color: var(--azul-resaltado) !important; }

    /* 6. Menú Lateral con Efectos Modernos */
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
    
    .dropdown-menu {
      background: var(--blanco-puro) !important; box-shadow: var(--sombra-caja) !important;
      border: 1px solid var(--borde-suave) !important; border-radius: .75rem !important; padding: .5rem !important;
    }
    .dropdown-item { color: var(--texto-oscuro) !important; transition: background-color var(--duracion-transicion) ease; }
    .dropdown-item:hover { background-color: rgba(13, 110, 253, 0.08) !important; }
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
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#"><i class="fas fa-expand-arrows-alt"></i></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="perfilDropdown" data-bs-toggle="dropdown" style="cursor:pointer;">
          <i class="fas fa-user-circle fa-lg mr-2"></i>
          <span><?php echo htmlspecialchars($_SESSION['usuario'] ?? 'Repartidor'); ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="perfilDropdown" style="min-width: 180px;">
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
      <span class="brand-text">Repartidor</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="cargarPagina('repartidorentregas.php')">
              <i class="fas fa-motorcycle nav-icon"></i>
              <p>Gestionar Entrega</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Contenido -->
  <div class="content-wrapper">
    <iframe src="../vistas/Inicio.php" id="iframe-contenido"></iframe>
  </div>

  <!-- Footer -->
  <footer class="main-footer">
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
<script src="dist/js/adminlte.min.js"></script>

<script>
    function ajustarAlturaIframe() {
      const iframe = document.getElementById('iframe-contenido');
      if (!iframe) return;

      const footer = document.querySelector('.main-footer');
      const windowHeight = window.innerHeight;
      const navbarHeight = document.querySelector('.main-header').offsetHeight;

      // Lógica de altura copiada de tu página de Cliente
      if (document.querySelector('.content-wrapper').classList.contains('layout-iframe-derecha')) {
        // En modo flex, la altura es 100% del viewport menos la navbar
        iframe.style.height = (windowHeight - navbarHeight) + 'px';
      } else {
        // En modo normal, restamos también el footer y un margen
        const footerHeight = footer.style.display !== 'none' ? footer.offsetHeight : 0;
        const margen = 40;
        iframe.style.height = (windowHeight - navbarHeight - footerHeight - margen) + 'px';
      }
    }

    function cargarPagina(pagina) {
      const iframe = document.getElementById('iframe-contenido');
      const contentWrapper = document.querySelector('.content-wrapper');
      const footer = document.querySelector('.main-footer');
      
      iframe.src = pagina;
      
      // Lógica de clases y display replicada de tu página de Cliente
      if (pagina.includes('repartidorentregas.php')) {
        footer.style.display = 'none';
        contentWrapper.classList.add('layout-iframe-derecha');
      } else { // Para 'Inicio.php' u otras páginas
        footer.style.display = 'block';
        contentWrapper.classList.remove('layout-iframe-derecha');
      }

      // Esperamos un momento y ajustamos la altura
      setTimeout(ajustarAlturaIframe, 100);
    }
    
    window.onload = () => {
        cargarPagina('../vistas/Inicio.php');
    };
    window.onresize = ajustarAlturaIframe;
</script>
</body>
</html>
