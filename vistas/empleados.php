<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestiae Empleados</title>

  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="plugins/bootstrap-5.3.7/css/bootstrap.min.css" />
  <!-- FontAwesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <!-- DataTables Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />
  <!-- Google Fonts Rubik -->
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

 <style>
    /* 1. PALETA DE COLORES Y ESTILOS BASE (Copiados de tu página de Productos) */
    :root {
      --azul-principal: #357ABD;
      --azul-oscuro: #2a5e91;
      --azul-claro: #6dd5ed;
      --blanco: #fff;
      --gris-fondo: #f9fafb;
      --sombra-suave: rgba(53, 122, 189, 0.15);
      --color-acento: #2193b0;
      --texto-principal: #34495e;
      --texto-secundario: #6c757d;
      --borde-input: #b2ebf2;
      --fondo-input: #f4f8fb;
    }

    body {
      font-family: 'Nunito', 'Rubik', sans-serif !important;
      background: #fff; /* Fondo blanco simple como en Productos */
      color: var(--texto-principal);
      padding: 1.5rem;
    }

    /* 2. TÍTULO PRINCIPAL (Estilo de Productos) */
    h2 {
      color: var(--color-acento);
      font-weight: 700;
      margin-bottom: 30px;
      font-size: 2rem;
      text-align: center;
      letter-spacing: 1px;
      text-shadow: 0 2px 8px #2193b080;
    }

    .form-container {
      max-width: 600px;
      margin: 0 auto 40px auto;
    }

   /* === DISEÑO DE FORMULARIO DE PRODUCTOS APLICADO A EMPLEADOS === */

:root {
  /* Variables consistentes con el diseño de productos */
  --azul-resaltado: #0d6efd;
  --blanco-puro: #ffffff;
  --fondo-claro: #f8f9fa;
  --borde-suave: #dee2e6;
  --texto-oscuro: #212529;
  --texto-secundario: #6c757d;
  --duracion-transicion: 0.2s;
}

#formRol {
  background: var(--blanco-puro);
  border: 1px solid var(--borde-suave);
  box-shadow: 0 10px 30px rgba(0,0,0,0.07);
  border-radius: 16px;
  padding: 2rem;
}

#formRol label {
  color: var(--texto-secundario);
  font-weight: 500;
  margin-bottom: .5rem;
  font-size: 0.9rem;
}

#formRol .form-control,
#formRol .form-select {
  border: 1px solid var(--borde-suave);
  border-radius: 8px;
  color: var(--texto-oscuro);
  font-weight: 500;
  background-color: var(--fondo-claro);
  box-shadow: none;
  transition: border-color var(--duracion-transicion) ease, box-shadow var(--duracion-transicion) ease;
}

#formRol .form-control::placeholder {
  color: #adb5bd;
  font-style: normal;
}

#formRol .form-control:focus,
#formRol .form-select:focus {
  border-color: var(--azul-resaltado);
  box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
  background-color: var(--blanco-puro);
}

#btnGuardarRol {
  background: var(--azul-resaltado);
  border: none;
  font-weight: 600;
  font-size: 1rem;
  width: 100%;
  padding: .85rem 1rem;
  color: var(--blanco-puro);
  border-radius: 8px;
  margin-top: 1rem;
  box-shadow: 0 4px 14px 0 rgba(13, 110, 253, 0.3);
  transition: all var(--duracion-transicion) ease;
  letter-spacing: 0.5px;
}

#btnGuardarRol:hover {
  background: #0b5ed7; /* Azul más oscuro */
  transform: translateY(-2px);
  box-shadow: 0 6px 16px 0 rgba(13, 110, 253, 0.4);
}

.text-danger { margin-bottom: 0; }
    /* 4. DISEÑO DE LA TARJETA DE LA TABLA (id="tablaRoles") - Adaptado de #tabla */
    .card.tabla-card {
      border-radius: 18px;
      box-shadow: 0 0 30px var(--sombra-suave);
      background: rgba(255,255,255,0.98);
      padding: 28px 18px;
      margin-top: 18px;
      border: 1.5px solid #b2ebf2;
      max-width: 1100px;
      margin-left: auto;
      margin-right: auto;
    }

    #tablaRoles {
      font-size: 1rem !important;
      width: 100% !important;
      border-radius: 12px;
      overflow: hidden;
      background: rgba(255,255,255,0.98);
      box-shadow: 0 2px 12px #2193b030;
    }

    #tablaRoles thead th {
      font-weight: 800;
      font-size: 1.08rem;
      background: linear-gradient(90deg, #2193b0 0%, #6dd5ed 100%);
      color: var(--blanco);
      border: none;
      letter-spacing: 0.5px;
      text-shadow: 0 2px 8px #2193b080;
    }

    #tablaRoles tbody tr:hover {
      background-color: #d9e7f7 !important;
      cursor: pointer;
      transition: background 0.3s;
    }

    /* Controles de la tabla (Buscador, Paginación) */
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
      font-size: 0.98rem;
      padding: 7px 12px;
      border-radius: 12px;
      border: 1.5px solid var(--borde-input);
      background-color: var(--fondo-input);
      font-weight: 500;
      box-shadow: inset 0 0 6px #e4e9f0;
      margin-bottom: 8px;
    }

    .dataTables_wrapper .dataTables_filter input:focus,
    .dataTables_wrapper .dataTables_length select:focus {
      border-color: var(--color-acento);
      box-shadow: 0 0 10px var(--color-acento);
      background-color: #eef5fb;
    }
</style>
</head>
<body class="hold-transition sidebar-mini">

  <div class="container-fluid mt-4 px-0" style="max-width: 100%;">
    <h2 style="color: #2193b0; font-weight: 800; text-align: center; margin-bottom: 32px; font-size: 2.1rem; letter-spacing: 1px;">Gestión empleados</h2>
    <!-- === NUEVO FORMULARIO DE EMPLEADOS (REEMPLAZAR) === -->
<div class="form-container">
  <form id="formRol" autocomplete="off" class="card">
    <input type="hidden" id="id_usuario" name="id_usuario" />
    
    <!-- Fila 1: Nombres y Apellidos -->
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="nombres">Nombres</label>
        <input type="text" name="nombres" id="nombres" placeholder="Nombres del empleado" class="form-control" />
        <div id="error-nombres" class="text-danger small mt-1"></div>
      </div>
      <div class="col-md-6 mb-3">
        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos del empleado" class="form-control" />
        <div id="error-apellidos" class="text-danger small mt-1"></div>
      </div>
    </div>

    <!-- Fila 2: Teléfono y Usuario -->
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono" placeholder="Número de teléfono" class="form-control" />
        <div id="error-telefono" class="text-danger small mt-1"></div>
      </div>
      <div class="col-md-6 mb-3">
        <label for="usuario">Nombre de Usuario</label>
        <input type="text" name="usuario" id="usuario" placeholder="Usuario para iniciar sesión" class="form-control" />
        <div id="error-usuario" class="text-danger small mt-1"></div>
      </div>
    </div>

    <!-- Fila 3: Contraseña y Rol -->
    <div class="row">
        <div class="col-md-6 mb-3" id="grupoContrasena">
            <label for="contrasena">Contraseña</label>
            <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña (dejar en blanco para no cambiar)" class="form-control" />
            <div id="error-contrasena" class="text-danger small mt-1"></div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="rol">Rol del Empleado</label>
            <select name="rol" id="rol" class="form-select"> <!-- Usamos form-select de Bootstrap 5 -->
                <option value="">--Seleccionar Rol--</option>
                <option value="cocinero">Cocinero</option>
                <option value="repartidor">Repartidor</option>
            </select>
        </div>
    </div>

    <!-- Fila 4: Botón -->
    <button type="button" id="btnGuardarRol" class="btn">Guardar Empleado</button>
  </form>
</div>
<!-- ======================================================= -->

    <div class="card tabla-card">
      <table id="tablaRoles" class="table table-bordered table-striped" style="background: transparent; box-shadow: none; border-radius: 0;"></table>
    </div>
  </div>

  <!-- Scripts -->
  <script src="plugins/jquery/jquery-3.7.1.js"></script>
  <script src="plugins/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../js/empleados.js?v=<?= time() ?>"></script>

</body>
</html>
