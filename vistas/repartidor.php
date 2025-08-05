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
      display: flex;
      flex-direction: column;
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

    .wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      flex: 1 0 auto;
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
      flex: 1 0 auto;
      animation: fadeIn 1.1s;
      min-width: 0;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
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

    .modal-content {
      background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%);
      color: #fff;
      border-radius: 22px;
      box-shadow: var(--glass-shadow);
      backdrop-filter: var(--glass-blur);
      border: none;
      padding: 0;
      overflow: hidden;
    }
    .modal-header {
      border-bottom: 2px solid #6dd5ed;
      background: rgba(53,122,189,0.92);
      color: #fff;
      font-weight: bold;
      font-size: 1.2rem;
      border-radius: 22px 22px 0 0;
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

    /* Responsive */
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
  function cargarPagina(pagina) {
    document.getElementById('iframe-contenido').src = pagina;
    // Oculta el pie de página y expande el iframe
    document.querySelector('.main-footer').style.display = 'none';
    document.querySelector('.content-wrapper').style.borderRadius = '0';
    document.querySelector('.content-wrapper').style.margin = '0';
    document.querySelector('.content-wrapper').style.padding = '0';
    document.querySelector('.content-wrapper').style.minHeight = '100vh';
    document.getElementById('iframe-contenido').style.height = '100vh';
  }

  // Si se vuelve a Inicio, muestra el pie y restaura estilos y altura del iframe
  document.querySelector("[onclick*='Inicio.php']").addEventListener('click', function() {
    document.querySelector('.main-footer').style.display = '';
    document.querySelector('.content-wrapper').style.borderRadius = '';
    document.querySelector('.content-wrapper').style.margin = '';
    document.querySelector('.content-wrapper').style.padding = '';
    document.querySelector('.content-wrapper').style.minHeight = '';
    document.getElementById('iframe-contenido').style.height = '74vh'; // Restaurar altura original
  });
</script>
</body>
</html>
