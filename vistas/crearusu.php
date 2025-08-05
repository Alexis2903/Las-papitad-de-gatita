<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro de Cliente</title>

  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="plugins/bootstrap-5.3.7/css/bootstrap.min.css" />
  <!-- FontAwesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <!-- Fuente Nunito -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet" />

 <style>
    /* ===================================================================
       DISEÑO DE REGISTRO CON FONDO CLARO (BASADO EN ESTILO LOGIN)
       =================================================================== */
    
    :root {
      --color-grad-1: #2193b0;
      --color-grad-2: #6dd5ed;
      --blanco: #ffffff;
      --texto-principal: #34495e;
      --texto-secundario: #6c757d;
      --borde-input: #b2ebf2;
      --sombra-suave: rgba(33, 147, 176, 0.15);
      --fondo-pagina: #f8f9fa; /* Variable para el nuevo fondo claro */
    }

    body {
      min-height: 100vh;
      /* --- ¡AQUÍ ESTÁ EL CAMBIO! --- */
      background-color: var(--fondo-pagina); 
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Nunito', sans-serif;
      padding: 20px;
      animation: fadeIn 1s;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .register-box {
      width: 100%;
      max-width: 480px;
      background: var(--blanco); /* Cambiado a blanco sólido para mejor contraste */
      border-radius: 16px;
      box-shadow: 0 12px 40px rgba(0,0,0,0.07); /* Sombra más sutil para fondo claro */
      padding: 20px;
      padding-top: 60px; /* Espacio para el icono que sobresale */
      position: relative;
      text-align: center;
      border: 1px solid #dee2e6; /* Borde sutil para definir la caja */
    }

    /* Icono superior que reemplaza la imagen */
    .register-icon {
      width: 90px;
      height: 90px;
      background: linear-gradient(135deg, var(--color-grad-1) 60%, var(--color-grad-2) 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      position: absolute;
      top: -45px; /* Mitad del icono sobresale */
      left: 50%;
      transform: translateX(-50%);
      box-shadow: 0 8px 20px rgba(33, 147, 176, 0.3);
      border: 4px solid var(--blanco);
    }
    .register-icon i {
      color: var(--blanco);
      font-size: 2.5rem;
    }

    .register-box h3 {
      font-weight: 700;
      color: var(--color-grad-1);
      margin-bottom: 8px;
      font-size: 1.8rem;
    }

    .register-box p.register-box-msg {
      color: var(--texto-principal);
      margin-bottom: 25px;
      font-size: 1rem;
    }

    .form-control {
      border-radius: 10px !important;
      border: 1px solid var(--borde-input) !important;
      padding: 12px 15px !important;
      font-size: 0.95rem;
      box-shadow: none !important;
    }
    .form-control:focus {
      border-color: var(--color-grad-1) !important;
      box-shadow: 0 0 0 3px rgba(33, 147, 176, 0.2) !important;
    }

    .input-group-text {
      background: linear-gradient(135deg, var(--color-grad-1) 60%, var(--color-grad-2) 100%) !important;
      border-radius: 0 10px 10px 0 !important;
      color: var(--blanco) !important;
      border: none !important;
    }

    .btn-primary.btn-block {
      background: linear-gradient(135deg, var(--color-grad-1) 60%, var(--color-grad-2) 100%);
      border: none;
      border-radius: 10px;
      padding: 12px 0;
      font-weight: 700;
      font-size: 1rem;
      letter-spacing: 0.5px;
      box-shadow: 0 5px 15px rgba(33, 147, 176, 0.3);
      transition: all 0.3s ease;
    }
    .btn-primary.btn-block:hover {
      transform: translateY(-2px);
      box-shadow: 0 7px 20px rgba(33, 147, 176, 0.4);
    }

    .login-link a {
      color: var(--color-grad-1);
      font-weight: 600;
      text-decoration: none;
      font-size: 0.9rem;
    }
    .login-link a:hover {
      text-decoration: underline;
    }

    .text-danger {
      font-size: 0.8rem;
      text-align: left;
      font-weight: 600;
      margin-top: 2px;
      margin-bottom: 8px;
    }
    #mensaje.alert {
      font-size: 0.9rem;
      padding: 0.75rem;
    }
    
    @media (max-width: 576px) {
        .register-box {
            margin: 20px 0;
            padding-left: 15px;
            padding-right: 15px;
        }
        .register-box h3 {
            font-size: 1.6rem;
        }
    }
  </style>
</head>
<body>

  <div class="register-box" role="main">
    <div class="register-icon" aria-hidden="true">
      <i class="fas fa-user-plus"></i>
    </div>
    
    <h3>Crear una Cuenta</h3>
    <p class="register-box-msg">Completa tus datos para registrarte.</p>

    <div id="mensaje" class="alert d-none text-center" role="alert"></div>

    <form id="formRegistroCliente" novalidate>
      <div class="row g-3">
        <!-- Nombres -->
        <div class="col-md-6">
          <div class="input-group">
            <input type="text" name="nombres" class="form-control" placeholder="Nombres" required />
            <span class="input-group-text"><i class="fas fa-user"></i></span>
          </div>
          <div id="error-nombres" class="text-danger"></div>
        </div>

        <!-- Apellidos -->
        <div class="col-md-6">
          <div class="input-group">
            <input type="text" name="apellidos" class="form-control" placeholder="Apellidos" required />
            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
          </div>
          <div id="error-apellidos" class="text-danger"></div>
        </div>

        <!-- Teléfono -->
        <div class="col-md-6">
          <div class="input-group">
            <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required />
            <span class="input-group-text"><i class="fas fa-phone"></i></span>
          </div>
          <div id="error-telefono" class="text-danger"></div>
        </div>

        <!-- Usuario -->
        <div class="col-md-6">
          <div class="input-group">
            <input type="text" name="usuario" class="form-control" placeholder="Usuario" required />
            <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
          </div>
          <div id="error-usuario" class="text-danger"></div>
        </div>

        <!-- Contraseña -->
        <div class="col-12">
           <div class="input-group">
            <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required />
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
          </div>
          <div id="error-contrasena" class="text-danger"></div>
        </div>
      </div>

      <!-- Botón de Registro -->
      <div class="d-grid mt-3">
        <button type="submit" class="btn btn-primary btn-block">Registrarme</button>
      </div>
    </form>

    <!-- Enlace para Iniciar Sesión -->
    <p class="mt-4 mb-0 login-link">
      <a href="logeo.php">
        <i class="fas fa-sign-in-alt"></i> ¿Ya tienes una cuenta? Inicia sesión
      </a>
    </p>
  </div>

  <!-- Scripts -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
  <script src="../js/crearusu.js"></script>
</body>
</html>