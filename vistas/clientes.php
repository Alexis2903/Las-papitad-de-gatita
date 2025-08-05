<!DOCTYPE html>
<html lang="es">
<head> 
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestión de Clientes</title>

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
 :root {
  --color-fondo: #ffffff;
  --color-blanco: #ffffff;
  --color-acento: #2193b0; /* azul principal */
  --color-acento-hover: #1b5f8a;
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
  font-size: 0.9rem; /* un poco más grande que antes */
  min-height: 100vh;
}

h2 {
  color: var(--color-acento) !important; /* título azul con !important para asegurar */
  font-weight: 700;
  margin-bottom: 25px;
  font-size: 1.5rem; /* tamaño un poco más grande */
  text-align: center;
  letter-spacing: 1px;
}

.container {
  max-width: 900px;
  margin: auto;
}

.card {
  display: none !important;
}

#tablaClientesTable, #tablaListado {
  font-size: 1rem !important; /* letra más visible */
  width: 100% !important;
  color: #212529;
  background: rgba(255,255,255,0.92);
  border-radius: 0 !important;
  border-collapse: collapse !important;
  box-shadow: 0 2px 12px #2193b030;
  overflow: visible;
}

#tablaClientesTable thead th, #tablaListado thead th {
  font-weight: 700;
  font-size: 1.1rem; /* encabezado un poco más grande */
  background: linear-gradient(90deg, #2193b0 0%, #6dd5ed 100%);
  color: #fff;
  border: 1px solid #1b5f8a;
  letter-spacing: 0.4px;
  text-shadow: 0 2px 8px #2193b080;
  text-align: center;
  padding: 12px 8px;
  white-space: nowrap;
}

#tablaClientesTable tbody td, #tablaListado tbody td {
  color: #212529;
  text-align: center;
  vertical-align: middle;
  padding: 12px 10px; /* un poco más espaciamiento */
  white-space: nowrap;
  background-color: var(--color-blanco);
  border: 1px solid #dee2e6;
}

#tablaClientesTable tbody tr:hover, #tablaListado tbody tr:hover {
  background-color: #d9e7f7 !important;
  cursor: pointer;
  color: #000000;
}

.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
  font-size: 0.9rem;
  padding: 6px 10px;
  border-radius: 12px;
  border: 1.5px solid var(--borde-input);
  background-color: var(--fondo-input);
  font-weight: 500;
  box-shadow: inset 0 0 6px #e4e9f0;
  margin-bottom: 8px;
  color: #000000;
}

.dataTables_wrapper .dataTables_filter input:focus,
.dataTables_wrapper .dataTables_length select:focus {
  border-color: var(--color-acento);
  box-shadow: 0 0 10px var(--color-acento);
  background-color: #eef5fb;
  outline: none;
}

@media (max-width: 768px) {
  .container {
    max-width: 100% !important;
    margin: 12px 2px;
    padding: 12px 2px;
    border-radius: 12px;
  }
  .card {
    padding: 12px 6px;
    max-width: 100%;
    margin-bottom: 18px;
    border-radius: 12px;
  }
  #tablaClientesTable, #tablaListado {
    font-size: 0.9rem !important;
    border-radius: 0 !important;
  }
}

  </style>
</head>
<body>


  <div class="container">
    <div class="mb-3">
      <h2 class="mb-0 text-center">Gestión de Clientes</h2>
    </div>


    <!-- Modal para agregar/editar cliente -->
    <div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="modalClienteLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glassmorphism-modal">
          <div class="modal-header" style="background: linear-gradient(90deg, #2193b0 0%, #6dd5ed 100%); color: #fff;">
            <h5 class="modal-title" id="modalClienteLabel">Editar Cliente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <form id="formCliente" autocomplete="off">
              <input type="hidden" id="id_usuario" name="id_usuario" />
              <div class="row g-3">
                <div class="col-md-6">
                  <input type="text" id="nombres" name="nombres" class="form-control" placeholder="Nombres" required />
                  <div class="error-msg" id="error-nombres"></div>
                </div>
                <div class="col-md-6">
                  <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Apellidos" required />
                  <div class="error-msg" id="error-apellidos"></div>
                </div>
                <div class="col-md-6">
                  <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Teléfono" required />
                  <div class="error-msg" id="error-telefono"></div>
                </div>
                <div class="col-md-6">
                  <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario" required />
                  <div class="error-msg" id="error-usuario"></div>
                </div>
              </div>
              <input type="hidden" name="rol" value="cliente" />
              <div class="d-flex gap-3 mt-4 flex-wrap justify-content-end">
                <button type="button" id="btnGuardar" class="btn btn-primary rounded-pill shadow">Guardar</button>
                <button type="button" id="btnCancelar" class="btn btn-secondary rounded-pill shadow" data-bs-dismiss="modal">Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div id="tablaClientes" class="table-responsive">
      <table class="table table-bordered table-striped" id="tablaClientesTable">
        <!-- Aquí se renderiza dinámicamente -->
      </table>
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
  <script src="../js/clientes.js?v=<?= time() ?>"></script>
</body>
</html>
