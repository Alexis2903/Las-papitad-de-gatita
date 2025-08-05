<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>FastFoodExpress - Información</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="plugins/bootstrap-5.3.7/css/bootstrap.min.css" />
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <style>
    .carousel-item img {
      height: 450px;
      object-fit: cover;
      border-radius: 10px;
    }

    .description-section {
      margin-top: 30px;
    }

    .navbar-custom {
      justify-content: flex-end;
    }

    .list-group-item i {
      color: #007bff;
      margin-right: 10px;
    }

    .contact-section {
      margin-top: 50px;
      padding: 40px 0;
      background-color: #f4f6f9;
      border-top: 1px solid #dee2e6;
    }

    .contact-icon {
      font-size: 30px;
      color: #007bff;
      margin-bottom: 10px;
    }
  </style>
</head>
<body class="hold-transition layout-top-nav">

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="#" class="navbar-brand">
        <i class="fas fa-hamburger mr-2"></i>
        <span class="brand-text font-weight-bold">La papitas de Gatita</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3 navbar-custom" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="../vistas/logeo.php" class="nav-link">Inicio de Sesión</a>
          </li>
          <li class="nav-item">
            <a href="../vistas/crearusu.php" class="nav-link">Crear cuenta</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Contenido -->
  <div class="content-wrapper bg-white">

    <!-- Carrusel -->
    <div class="content pt-3">
      <div class="container">
        <div id="carouselProductos" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="../vistas/imagenes/Hamburgesa.png" class="d-block w-100" alt="Hamburguesa">
            </div>
            <div class="carousel-item">
              <img src="../vistas/imagenes/salchipa.png" class="d-block w-100" alt="Papas">
            </div>
            <div class="carousel-item">
              <img src="../vistas/imagenes/hotdog.png" class="d-block w-100" alt="Bebida">
            </div>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#carouselProductos" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselProductos" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Descripciones -->
    <div class="content description-section">
      <div class="container">
        <h2 class="text-center text-primary"><i class="fas fa-utensils"></i> Nuestros Productos</h2>
        <p class="text-center mt-3">Explora nuestra variedad de opciones deliciosas:</p>
        <ul class="list-group list-group-flush mt-4">
          <li class="list-group-item"><i class="fas fa-hamburger"></i><strong> Hamburguesa Clásica:</strong> Pan artesanal, carne 100% de res, vegetales frescos y nuestra salsa secreta.</li>
          <li class="list-group-item"><i class="fas fa-utensils"></i><strong> Papas Fritas:</strong> Crujientes por fuera, suaves por dentro, perfectas como acompañante.</li>
          <li class="list-group-item"><i class="fas fa-glass-martini-alt"></i><strong> Bebidas Refrescantes:</strong> Gaseosas, jugos naturales y más para calmar tu sed.</li>
        </ul>
      </div>
    </div>

    <!-- Sección de Contacto -->
    <div class="contact-section">
      <div class="container">
        <h2 class="text-center text-primary"><i class="fas fa-phone-alt"></i> Contáctanos</h2>
        <div class="row text-center mt-4">
          <div class="col-md-4">
            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
            <p><strong>Dirección:</strong><br> Av. Quito cerca a la escuela</p>
          </div>
          <div class="col-md-4">
            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
            <p><strong>Correo:</strong><br> thaliagonzales@gmail.com</p>
          </div>
          <div class="col-md-4">
            <div class="contact-icon"><i class="fas fa-phone"></i></div>
            <p><strong>Teléfono:</strong><br> 0994307745</p>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>FastFoodExpress</strong> &copy; 2025 - Todos los derechos reservados.
  </footer>
</div>

<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
