<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inicio de Sesión</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="plugins/bootstrap-5.3.7/css/bootstrap.min.css" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
    <!-- Estilos personalizados -->
    <style>
    body.login-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', 'Roboto', sans-serif;
        padding: 15px;
        animation: fadeIn 1s;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .login-box {
        background: rgba(255,255,255,0.9);
        border-radius: 16px; /* Reducido para un look más sutil */
        box-shadow: 0 10px 35px rgba(33,147,176,0.15); /* Sombra ajustada */
        display: flex;
        overflow: hidden;
        max-width: 800px; /* Reducido para ser más compacto */
        width: 100%;
        backdrop-filter: blur(8px);
        border: 1px solid #e3e3e3;
        min-height: 440px; /* Altura mínima para mantener la forma */
    }

    .login-image {
        flex: 1 1 50%;
        background: url('dist/img/logo.png') center center no-repeat;
        background-size: cover;
        border-radius: 16px 0 0 16px; /* Coincide con el nuevo borde */
    }

    .login-form-container {
        flex: 1 1 50%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 20px;
    }
    
    .login-form-container form {
        width: 100%;
        max-width: 280px; /* Un poco más de espacio para el form */
        margin: 0 auto;
    }

    .login-form-container h3 {
        font-weight: 700; /* Ligeramente más fino */
        color: #2193b0;
        margin-bottom: 8px;
        text-align: center;
        font-size: 1.6rem; /* Reducido */
        letter-spacing: 0.5px;
    }

    .login-form-container p.login-box-msg {
        color: #6c757d;
        text-align: center;
        margin-bottom: 25px; /* Reducido significativamente */
        font-size: 1rem; /* Reducido */
    }

    .form-control {
        border-radius: 10px; /* Reducido */
        padding: 12px; /* Reducido */
        font-size: 0.95rem; /* Reducido */
        box-shadow: 0 2px 8px rgba(33,147,176,0.07);
        border: 1px solid #b2ebf2;
    }

    .input-group-text {
        background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%);
        color: #fff;
        border-radius: 0 10px 10px 0; /* Coincide con el input */
        font-size: 1.1rem; /* Reducido */
        border: none;
        padding: 0 12px; /* Ajuste de padding */
    }
    
    .input-group .form-control {
        border-right: none; /* Evita doble borde */
    }
    .input-group .form-control:focus {
        border-color: #6dd5ed;
        box-shadow: 0 0 0 2px rgba(33, 147, 176, 0.2);
    }

    .btn-primary {
        background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%);
        border: none;
        border-radius: 10px; /* Reducido */
        font-weight: 600; /* Ligeramente más fino */
        padding: 12px; /* Reducido */
        font-size: 1rem; /* Reducido */
        box-shadow: 0 4px 15px rgba(33,147,176,0.2);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #6dd5ed 0%, #2193b0 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(33,147,176,0.3);
    }

    .toggle-password {
        cursor: pointer;
        color: #fff !important;
        transition: color 0.2s;
    }

    .text-link {
        text-align: center;
        margin-top: 20px; /* Reducido */
    }

    .text-link a {
        color: #2193b0;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
        font-size: 0.9rem; /* Ligeramente más pequeño */
    }

    .text-link a:hover {
        color: #6dd5ed;
        text-decoration: underline;
    }
    
    /* Mensaje de error más compacto */
    #mensajeError {
        display: none;
        font-size: 0.9rem;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px; /* Espacio antes del formulario */
    }
    
    /* Media Query para móvil */
    @media (max-width: 768px) {
        body.login-page {
            align-items: flex-start; /* Permite scroll si el contenido es largo */
        }
        .login-box {
            flex-direction: column;
            min-height: auto;
            margin-top: 20px;
        }
        .login-image {
            min-height: 150px;
            height: 150px;
            border-radius: 16px 16px 0 0; /* Coincide con el borde */
            background-size: contain;
        }
        .login-form-container {
            padding: 30px 20px;
            border-radius: 0 0 16px 16px;
        }
    }
</style>
</head>

<body class="login-page">
    <div class="login-box">
        <div class="login-image" aria-label="Logo de bienvenida"></div>
        <div class="login-form-container">
            <h3>Bienvenido</h3>
            <p class="login-box-msg">Inicia sesión para acceder al sistema</p>
            <div id="mensajeError" class="alert alert-danger" role="alert"></div>
            <form id="formLogin">
                <div class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="usuario" placeholder="Usuario" required />
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="input-group">
                        <input type="password" class="form-control" name="contrasena" id="password" placeholder="Contraseña" required />
                        <button type="button" class="input-group-text toggle-password" onclick="togglePassword()" aria-label="Mostrar u ocultar contraseña">
                            <i id="eye-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                </div>
            </form>
            <div class="text-link">
                <a href="../vistas/crearusu.php">Crear cuenta</a>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 5 -->
    <script src="plugins/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
    <!-- Script personalizado -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eye-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
    <script src="../js/logeo.js"></script>
</body>

</html>
