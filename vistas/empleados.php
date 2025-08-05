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
   :root {
  --color-fondo: #ffffff;
  --color-blanco: #ffffff;
  --color-acento: #8cbfdb;
  --color-acento-hover: #79a9ce;
  --texto-principal: #445566;
  --texto-secundario: #7a8a99;
  --fondo-input: #ffffff;
  --borde-input: #cbd6e2;
  --error-color: #e07a5f;
  --sombra-suave: rgba(140, 191, 219, 0.25);
}

body {
  font-family: 'Rubik', sans-serif !important;
  background-color: var(--color-fondo);
  color: var(--texto-principal);
  margin: 0;
  padding: 30px 15px;
  font-size: 0.95rem;
  min-height: 100vh;
}

h2 {
  color: #000000; /* negro */
  font-weight: 700; /* negrilla */
  margin-bottom: 30px;
  font-size: 1.75rem;
  text-align: center;
  letter-spacing: 1px;
}


.form-container {
  max-width: 600px;
  margin: 0 auto 40px auto;
}

/* Formulario sin recuadro ni sombra */
#formRol {
  background-color: transparent;
  box-shadow: none;
  border-radius: 0;
  padding: 0;
}

#formRol .form-control,
#formRol .form-control-file,
#formRol textarea,
#formRol select.form-control {
  border: 2px solid #6dd5ed;
  border-radius: 10px;
  color: var(--texto-principal);
  font-weight: 500;
  font-size: 0.95rem;
  padding: 10px 14px;
  margin-bottom: 15px;
  background-color: #eaf6fb;
  min-height: 48px;
  font-size: 1.15rem;
  padding-top: 10px;
  padding-bottom: 10px;
  box-shadow: inset 0 0 8px #b2ebf2;
  transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
}

/* Placeholder negro normal, no cursiva */
#formRol .form-control::placeholder,
#formRol textarea::placeholder {
  color: #000000;
  font-style: normal;
}

#formRol .form-control:focus,
#formRol textarea:focus,
#formRol select.form-control:focus {
  border-color: var(--color-acento);
  box-shadow: 0 0 10px var(--color-acento);
  background-color: #eef5fb;
  outline: none;
  color: var(--texto-principal);
}

#grupoContrasena {
  margin-bottom: 12px;
}

.text-danger {
  color: var(--error-color) !important;
  font-weight: 600;
  font-size: 0.85rem;
  margin-top: -14px;
  margin-bottom: 12px;
  min-height: 18px;
  letter-spacing: 0.3px;
}

#rol {
  font-weight: 500;
}
#btnGuardarRol {
  background-color: #ffffff; /* blanco puro y brillante */
  border: 2px solid #000000; /* borde negro intenso */
  font-weight: 900; /* negrilla fuerte */
  font-size: 1rem;
  width: 100%;
  padding: 12px;
  color: #000000; /* texto negro intenso */
  border-radius: 12px;
  box-shadow: none;
  transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
  cursor: pointer;
  user-select: none;
}

#btnGuardarRol:hover {
  background-color: var(--color-acento);
  color: var(--color-blanco);
  border-color: var(--color-acento);
  box-shadow: 0 8px 25px #f1f5f8aa;
}



.card.tabla-card {
  border-radius: 18px;
  box-shadow: 0 0 30px var(--sombra-suave);
  background: rgba(255,255,255,0.98);
  padding: 28px 18px;
  margin-top: 18px;
  backdrop-filter: blur(8px);
  border: 1.5px solid #e8f7f9ff;
  max-width: 1100px;
  color: var(--texto-principal);
  border: none !important;
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
  color: var(--color-blanco);
  border: none;
  letter-spacing: 0.5px;
  text-shadow: 0 2px 8px #2193b080;
}

#tablaRoles tbody tr:hover {
  background-color: #d9e7f7 !important;
  cursor: pointer;
  transition: background 0.3s;
}

.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
  font-size: 0.9rem;
  padding: 5px 8px;
  border-radius: 10px;
  border: 1.5px solid var(--borde-input);
  background-color: var(--fondo-input);
  font-weight: 500;
  box-shadow: inset 0 0 6px #e4e9f0;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  color: #000000;
}

.dataTables_wrapper .dataTables_filter input:focus,
.dataTables_wrapper .dataTables_length select:focus {
  border-color: var(--color-acento);
  box-shadow: 0 0 10px var(--color-acento);
  background-color: #eef5fb;
  outline: none;
}

@media (max-width: 576px) {
  body {
    padding: 20px 10px;
  }
  #formRol {
    padding: 20px;
    max-width: 100%;
  }
  .card.tabla-card {
    padding: 20px 15px;
    max-width: 100%;
    margin-bottom: 30px;
  }
  #btnGuardarRol {
    font-size: 0.95rem;
    padding: 12px 0;
  }
}

  </style>
</head>
<body class="hold-transition sidebar-mini">

  <div class="container-fluid mt-4 px-0" style="max-width: 100%;">
    <h2 style="color: #2193b0; font-weight: 800; text-align: center; margin-bottom: 32px; font-size: 2.1rem; letter-spacing: 1px;">Gestión empleados</h2>
    <div class="form-container">
      <form id="formRol" autocomplete="off" class="card p-0" style="background: #fff; box-shadow: 0 0 18px #2193b030; border-radius: 16px;">
        <div class="px-4 pb-4 pt-2">
          <input type="hidden" id="id_usuario" name="id_usuario" />
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="nombres" id="nombres" placeholder="Nombres" class="form-control" />
              <div id="error-nombres" class="text-danger"></div>
            </div>
            <div class="col-md-6">
              <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" class="form-control" />
              <div id="error-apellidos" class="text-danger"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="telefono" id="telefono" placeholder="Teléfono" class="form-control" />
              <div id="error-telefono" class="text-danger"></div>
            </div>
            <div class="col-md-6">
              <input type="text" name="usuario" id="usuario" placeholder="Usuario" class="form-control" />
              <div id="error-usuario" class="text-danger"></div>
            </div>
          </div>
          <div id="grupoContrasena">
            <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" class="form-control" />
          </div>
          <div id="error-contrasena" class="text-danger"></div>
          <select name="rol" id="rol" class="form-control">
            <option value="">--Seleccionar Rol--</option>
            <option value="cocinero">Cocinero</option>
            <option value="repartidor">Repartidor</option>
          </select>
          <button type="button" id="btnGuardarRol" style="background: linear-gradient(90deg, #2193b0 0%, #6dd5ed 100%); color: #fff; font-weight: 700; border: none; border-radius: 10px; margin-top: 10px; box-shadow: 0 4px 16px #2193b040;">Guardar</button>
        </div>
      </form>
    </div>

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
