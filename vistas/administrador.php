<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: logeo.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Panel Administrador - Comida Rápida</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />

 <style>
    /* 1. Paleta de colores definida */
    :root {
      --azul-resaltado: #0d6efd;
      --blanco-puro: #ffffff;
      --fondo-principal: #f4f6f9;
      --borde-suave: #dee2e6;
      --sombra-caja: 0 6px 18px rgba(0, 0, 0, 0.08); /* Sombra un poco más difusa */
      --texto-oscuro: #343a40;
      --duracion-transicion: 0.25s; /* Variable para controlar la velocidad de las animaciones */
    }

    /* 2. Estilos base del body */
    body {
      font-family: 'Nunito', 'Rubik', sans-serif;
      background: var(--fondo-principal) !important;
      color: var(--texto-oscuro);
      overflow-x: hidden;
    }
    
    /* TU LAYOUT ORIGINAL (NO SE TOCA) */
    .wrapper { display: flex; flex-direction: column; min-height: 100vh; }
    .content-wrapper { flex-grow: 1; display: flex; flex-direction: column; background: transparent; margin: 1rem; padding: 0; border-radius: 22px; }
    iframe { width: 100%; height: 100%; flex-grow: 1; border: none; border-radius: 22px; box-shadow: var(--sombra-caja); background-color: var(--blanco-puro); }
    .content-fullscreen { margin: 0 !important; border-radius: 0 !important; }
    .content-fullscreen iframe { border-radius: 0 !important; box-shadow: none; }


    /* --- MEJORAS DE DISEÑO MODERNO --- */

    .main-header.navbar, .main-sidebar {
      background: var(--blanco-puro);
      border: none;
      /* Se quita la sombra para un look más plano, la separación la da el color de fondo */
    }

    .brand-link { border-bottom: 1px solid var(--borde-suave); }
    .brand-link .brand-text { color: var(--azul-resaltado) !important; font-weight: 700; }
    .brand-link img { height: 38px; }

    .main-header .nav-link { color: var(--azul-resaltado) !important; font-weight: 500; }
    
    /* MEJORA 1: TRANSICIONES Y MICRO-INTERACCIONES EN EL MENÚ */
    .sidebar .nav-link {
      color: var(--azul-resaltado);
      border-radius: 8px;
      margin: 4px 10px;
      font-weight: 500;
      position: relative; /* Necesario para el indicador visual */
      /* Transición suave para todos los cambios */
      transition: transform var(--duracion-transicion) ease, background-color var(--duracion-transicion) ease;
    }
    .sidebar .nav-link .nav-icon {
      color: var(--azul-resaltado);
      /* Transición suave para el ícono */
      transition: transform var(--duracion-transicion) ease, color var(--duracion-transicion) ease;
    }

    /* Efecto al pasar el mouse */
    .sidebar .nav-link:hover {
      background-color: rgba(13, 110, 253, 0.08); /* Fondo azul muy sutil */
      transform: translateX(5px); /* Se desplaza un poco a la derecha */
    }
    .sidebar .nav-link:hover .nav-icon {
      /* El ícono rota y escala un poco */
      transform: scale(1.1) rotate(-5deg);
    }

    /* Link activo en el menú */
    .sidebar .nav-link.active {
      background: var(--azul-resaltado);
      color: var(--blanco-puro) !important;
      box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4);
      transform: translateX(5px) scale(1.02); /* Lo hacemos ligeramente más grande y movido */
    }
    .sidebar .nav-link.active p,
    .sidebar .nav-link.active .nav-icon {
      color: var(--blanco-puro) !important;
      transform: none; /* Reseteamos la transformación del hover en el ícono */
    }
    
    /* MEJORA 2: INDICADOR VISUAL PARA EL LINK ACTIVO */
    .sidebar .nav-link.active::before {
      content: '';
      position: absolute;
      left: -10px; /* Lo posicionamos fuera del botón, en el margen */
      top: 50%;
      transform: translateY(-50%);
      height: 70%;
      width: 4px;
      background-color: var(--azul-resaltado);
      border-radius: 4px;
    }
    
    .main-footer {
      background: var(--blanco-puro);
      color: var(--texto-oscuro);
      border-top: 1px solid var(--borde-suave);
    }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
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
          <span><?php echo htmlspecialchars($_SESSION['usuario'] ?? 'Administrador'); ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="perfilDropdown" style="min-width: 180px;">
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
      <span class="brand-text">Comida Rápida</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="cargarPagina('productos.php')">
              <i class="fas fa-hamburger nav-icon"></i>
              <p>Gestión de Productos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="cargarPagina('empleados.php')">
              <i class="fas fa-user-tie nav-icon"></i>
              <p>Gestión de Empleados</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="cargarPagina('clientes.php')">
              <i class="fas fa-users nav-icon"></i>
              <p>Gestión de Clientes</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="cargarPagina('entrega.php')">
              <i class="fas fa-motorcycle nav-icon"></i>
              <p>Entregas</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Contenido -->
  <div class="content-wrapper">
    <iframe src="../vistas/Inicio.php" id="iframe-contenido" title="Contenido"></iframe>
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
  function cargarPagina(pagina) {
    const iframe = document.getElementById('iframe-contenido');
    const footer = document.querySelector('.main-footer');
    const contentWrapper = document.querySelector('.content-wrapper');

    iframe.src = pagina;

    // MEJORA 4: Lógica simplificada. Solo ocultamos/mostramos elementos.
    // El layout flexible se encarga del tamaño automáticamente.
    if (pagina.includes('pedido.php')) {
      footer.style.display = 'none';
      contentWrapper.classList.add('content-fullscreen');
    } else {
      footer.style.display = 'block'; // Usar 'block' o ''
      contentWrapper.classList.remove('content-fullscreen');
    }
  }

  // Tu código de DOMContentLoaded puede ser eliminado o simplificado
  document.addEventListener('DOMContentLoaded', () => {
    // Esto asegura que al cargar la página por primera vez, todo esté visible
    cargarPagina('../vistas/Inicio.php'); 
  });
</script>
</body>
</html>
