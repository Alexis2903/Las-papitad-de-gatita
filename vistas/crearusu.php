<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro de Cliente</title>

  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />
  <!-- Bootstrap 5 -->

    <script src="plugins/bootstrap-5.3.7/css/bootstrap.min.css"></script>
  <!-- FontAwesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <!-- Fuente Nunito -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet" />

  <style>
    :root {
      --azul-principal: #357ABD;
      --azul-oscuro: #2a5e91;
      --gris-fondo: #f9fafb;
      --blanco: #fff;
      --sombra-suave: rgba(53, 122, 189, 0.15);
      --texto-principal: #34495e;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #6dd5ed 0%, #2193b0 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Nunito', sans-serif;
      padding: 0;
      margin: 0;
      color: var(--texto-principal);
      user-select: none;
      animation: fadeIn 1s;
      position: relative;
      overflow: hidden;
    }

    /* Fondo decorativo con formas */
    body::before {
      content: '';
      position: absolute;
      top: -120px;
      left: -120px;
      width: 340px;
      height: 340px;
      background: radial-gradient(circle, #2193b0 60%, #6dd5ed 100%);
      opacity: 0.18;
      border-radius: 50%;
      z-index: 0;
    }
    body::after {
      content: '';
      position: absolute;
      bottom: -100px;
      right: -100px;
      width: 260px;
      height: 260px;
      background: radial-gradient(circle, #6dd5ed 60%, #2193b0 100%);
      opacity: 0.15;
      border-radius: 50%;
      z-index: 0;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .register-box {
      width: 480px;
      max-width: 98vw;
      background: rgba(255,255,255,0.92);
      border-radius: 28px;
      box-shadow: 0 16px 48px var(--sombra-suave);
      padding: 32px 28px 24px 28px;
      transition: box-shadow 0.3s ease;
      backdrop-filter: blur(10px);
      position: relative;
      overflow: hidden;
      z-index: 1;
      animation: fadeIn 1.2s;
      margin: auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .register-box:hover {
      box-shadow: 0 24px 64px rgba(53, 122, 189, 0.28);
      transform: translateY(-2px) scale(1.01);
    }

    .register-box .icon-user {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 10px;
      animation: bounceIn 1.2s;
    }
    @keyframes bounceIn {
      0% { transform: scale(0.7); opacity: 0; }
      60% { transform: scale(1.15); opacity: 1; }
      80% { transform: scale(0.95); }
      100% { transform: scale(1); }
    }
    .register-box .icon-user i {
      font-size: 4.2rem;
      color: #fff;
      background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%);
      border-radius: 50%;
      padding: 22px;
      box-shadow: 0 4px 18px var(--sombra-suave);
      border: 4px solid #fff;
    }

    .register-box h3 {
      font-weight: 900;
      color: var(--azul-principal);
      margin-bottom: 10px;
      text-align: center;
      font-size: 2.1rem;
      user-select: none;
      letter-spacing: 1px;
    }

    p.text-center {
      font-weight: 500;
      color: var(--azul-oscuro);
      margin-bottom: 24px;
      font-size: 1.08rem;
    }

    #mensaje {
      margin-bottom: 20px;
      font-weight: 600;
      font-size: 0.95rem;
    }

    .form-control {
      border-radius: 16px !important;
      border: 2px solid #b2ebf2 !important;
      padding: 15px 20px !important;
      font-size: 1.05rem;
      font-weight: 500;
      transition: border-color 0.3s ease, box-shadow 0.3s ease !important;
      user-select: text;
      box-shadow: 0 2px 8px var(--sombra-suave);
      background: rgba(255,255,255,0.98);
    }

    .form-control:focus {
      border-color: var(--azul-principal) !important;
      box-shadow: 0 0 10px rgba(53, 122, 189, 0.4) !important;
      outline: none;
    }

    .input-group-text {
      background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%) !important;
      border-radius: 0 16px 16px 0 !important;
      color: #fff !important;
      border: none !important;
      font-size: 1rem;
      user-select: none;
      box-shadow: 0 2px 8px var(--sombra-suave);
      padding: 0.375rem 0.75rem !important;
    }
    .input-group-text i {
      font-size: 1.1rem !important;
    }

    button.btn-primary.btn-block {
      background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%);
      border: none;
      border-radius: 16px;
      padding: 15px 0;
      font-weight: 800;
      font-size: 1.15rem;
      letter-spacing: 1px;
      transition: background 0.3s, box-shadow 0.3s;
      user-select: none;
      box-shadow: 0 6px 15px rgba(53, 122, 189, 0.35);
    }

    button.btn-primary.btn-block:hover,
    button.btn-primary.btn-block:focus {
      background: linear-gradient(135deg, #6dd5ed 0%, #2193b0 100%);
      box-shadow: 0 8px 25px rgba(42, 94, 145, 0.6);
      outline: none;
      transform: translateY(-2px) scale(1.03);
    }

    p a {
      color: var(--azul-principal);
      font-weight: 700;
      text-decoration: none;
      transition: color 0.3s ease;
      user-select: none;
    }

    p a:hover,
    p a:focus {
      color: var(--azul-oscuro);
      text-decoration: underline;
      outline: none;
    }

    /* Mensajes de error */
    .text-danger {
      font-size: 0.85rem;
      font-weight: 600;
      margin-top: -10px;
      margin-bottom: 10px;
      user-select: none;
    }

    @media (max-width: 576px) {
      .register-box {
        padding: 18px 4px;
      }

      .register-box h3 {
        font-size: 1.1rem;
      }

      button.btn-primary.btn-block {
        font-size: 0.9rem;
        padding: 8px 0;
      }
    }
  </style>
</head>

<body>
  <div class="register-box" role="main" aria-label="Formulario de registro de cliente">
    <div class="icon-user"><i class="fas fa-user-plus" aria-hidden="true"></i></div>
    <h3>Registro de Cliente</h3>
    <p class="text-center">Completa los datos para crear tu cuenta</p>

    <div id="mensaje" class="alert alert-danger d-none text-center" role="alert" aria-live="polite"></div>

    <form id="formRegistroCliente" novalidate>
      <div class="row g-2 mb-2">
        <div class="col-6">
          <div class="input-group mb-2">
            <input type="text" name="nombres" class="form-control" placeholder="Nombres" required aria-describedby="error-nombres" />
            <span class="input-group-text"><i class="fas fa-user" aria-hidden="true"></i></span>
          </div> </br>
          <div id="error-nombres" class="text-danger small mb-2" aria-live="assertive"></div>
          <div class="input-group mb-2">
            <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required aria-describedby="error-telefono" />
            <span class="input-group-text"><i class="fas fa-phone" aria-hidden="true"></i></span>
          </div>
          <div id="error-telefono" class="text-danger small mb-2" aria-live="assertive"></div>
        </div>
        <div class="col-6">
          <div class="input-group mb-2">
            <input type="text" name="apellidos" class="form-control" placeholder="Apellidos" required aria-describedby="error-apellidos" />
            <span class="input-group-text"><i class="fas fa-user-tag" aria-hidden="true"></i></span>
          </div> </br>
          <div id="error-apellidos" class="text-danger small mb-2" aria-live="assertive"></div>
          <div class="input-group mb-2">
            <input type="text" name="usuario" class="form-control" placeholder="Usuario" required aria-describedby="error-usuario" />
            <span class="input-group-text"><i class="fas fa-user-circle" aria-hidden="true"></i></span>
          </div>
          <div id="error-usuario" class="text-danger small mb-2" aria-live="assertive"></div>
        </div>
      </div>
      <div class="input-group mb-3">
        <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required aria-describedby="error-contrasena" />
        <span class="input-group-text"><i class="fas fa-lock" aria-hidden="true"></i></span>
      </div>
      <div id="error-contrasena" class="text-danger small mb-2" aria-live="assertive"></div>
      <div class="row mb-2">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" aria-label="Registrar cuenta de cliente">Registrar</button>
        </div>
      </div>
    </form>
    <!-- La lógica de redirección y JS se encuentra ahora en crearusu.js -->


    <div id="mensaje" class="alert d-none text-center" role="alert" aria-live="polite"></div>

    <p class="mt-3 mb-0 text-center">
      <a href="logeo.php" aria-label="Ir a página de inicio de sesión">
        <i class="fas fa-sign-in-alt" aria-hidden="true"></i> ¿Ya tienes una cuenta? Inicia sesión
      </a>
    </p>
  </div>

  <!-- Scripts -->
  <script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
  <script src="../js/crearusu.js"></script>
</body>

</html>
