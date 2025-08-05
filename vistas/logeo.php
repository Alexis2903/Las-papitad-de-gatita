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
            background: linear-gradient(135deg, #fcfdfdff 0%, #fcfdfdff 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            padding: 20px;
            animation: fadeIn 1s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .login-box {
            background: rgba(255,255,255,0.85);
            border-radius: 24px;
            box-shadow: 0 12px 40px rgba(33,147,176,0.18);
            display: flex;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            backdrop-filter: blur(8px);
            border: 1px solid #e3e3e3;
            height: 420px;
        }

        .login-image {
            flex: 1 1 50%;
            min-width: 0;
            height: 100%;
            background: url('dist/img/logo.png') center center no-repeat;
            background-size: cover;
            border-radius: 24px 0 0 24px;
        }

        @media (max-width: 900px) {
            .login-box {
                flex-direction: column;
                height: auto;
            }
            .login-image {
                min-height: 140px;
                height: 180px;
                border-radius: 24px 24px 0 0;
                background-size: contain;
            }
        }

        .login-form-container {
            flex: 1 1 50%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: rgba(255,255,255,0.95);
            border-radius: 0 24px 24px 0;
        }
        .login-form-container form {
            width: 100%;
            max-width: 260px;
            margin: 0 auto;
        }
        .login-form-container h3,
        .login-form-container p.login-box-msg,
        .login-form-container .text-link {
            max-width: 260px;
            margin-left: auto;
            margin-right: auto;
        }
        .login-form-container {
            /* ...existing code... */
            align-items: center;
        }

        .login-form-container h3 {
            font-weight: 800;
            color: #2193b0;
            margin-bottom: 8px;
            text-align: center;
            letter-spacing: 1px;
        }

        .login-form-container p.login-box-msg {
            color: #6c757d;
            text-align: center;
            margin-bottom: 32px;
            font-size: 1.1rem;
        }

        .form-control {
            border-radius: 14px;
            padding: 14px;
            font-size: 1.05rem;
            box-shadow: 0 2px 8px rgba(33,147,176,0.07);
            border: 1px solid #b2ebf2;
        }

        .input-group-text {
            background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%);
            color: #fff;
            border-radius: 0 14px 14px 0;
            font-size: 1.2rem;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2193b0 60%, #6dd5ed 100%);
            border: none;
            border-radius: 14px;
            font-weight: 700;
            padding: 14px;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(33,147,176,0.12);
            transition: background 0.3s ease, transform 0.2s;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #6dd5ed 0%, #2193b0 100%);
            transform: translateY(-2px) scale(1.03);
        }

        .toggle-password {
            cursor: pointer;
            padding: 0 10px;
            color: #fff !important;
            transition: color 0.2s;
        }
        .toggle-password:hover {
            color: #fff !important;
        }

        .text-link {
            text-align: center;
            margin-top: 24px;
        }

        .text-link a {
            color: #2193b0;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .text-link a:hover {
            color: #6dd5ed;
            text-decoration: underline;
        }

        #mensajeError {
            display: none;
            font-size: 1rem;
            border-radius: 10px;
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
