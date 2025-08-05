<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cocinero') {
    header("Location: logeo.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Pedidos para Cocinero</title>

  <!-- Bootstrap 4 -->
<link rel="stylesheet" href="plugins/bootstrap-5.3.7/css/bootstrap.min.css" />
  <!-- FontAwesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <!-- DataTables Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />

  <!-- Tipografía Nunito desde Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

  <style>
    :root {
      --azul-suave: #5a8dbd;
      --azul-oscuro: #3b659c;
      --gris-claro: #f5f7fa;
      --blanco: #ffffff;
      --texto-principal: #3a4a63;
      --texto-secundario: #6c7a93;
      --sombra-suave: rgba(90, 141, 189, 0.15);
    }

    body {
      font-family: 'Nunito', sans-serif;
      background-color: var(--gris-claro);
      color: var(--texto-principal);
      margin: 0;
      padding: 40px 30px; /* un poco más de padding lateral para no pegarse */
      min-height: 100vh;
    }

    h2 {
      font-weight: 700;
      font-size: 2.4rem;
      color: var(--azul-suave);
      margin-bottom: 50px;
      letter-spacing: 1.2px;
      text-shadow: 0 2px 5px rgba(90,141,189,0.3);
    }

    .filtro-container {
      max-width: 420px;
      margin: 0 auto 40px auto;
      text-align: center;
    }

    label[for="selectEvento"] {
      font-weight: 600;
      color: var(--azul-oscuro);
      margin-bottom: 8px;
      display: block;
      user-select: none;
      font-size: 1rem;
    }

    select.form-control {
      border-radius: 12px;
      padding-left: 15px;
      height: 40px;
      font-weight: 500;
      border: 1.7px solid var(--azul-suave);
      color: var(--azul-oscuro);
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      background-color: var(--blanco);
      box-shadow: inset 0 0 8px #d4e0f0;
      font-size: 1rem;
    }

    select.form-control:focus {
      border-color: var(--azul-oscuro);
      box-shadow: 0 0 14px var(--azul-suave);
      outline: none;
      background-color: #e8f0fc;
      color: var(--azul-oscuro);
    }

    /* Tabla en ancho completo */
    .table-responsive {
      width: 100% !important;
      background: var(--blanco);
      border-radius: 14px;
      box-shadow: 0 12px 30px var(--sombra-suave);
      overflow-x: auto;
      padding: 10px 15px;
      margin: 0 auto;
    }

    table {
      border-collapse: separate !important;
      border-spacing: 0 12px !important;
      width: 100% !important;
      font-size: 1rem;
    }

    thead th {
      background: linear-gradient(90deg, #7aa3ce, #5a8dbd);
      color: #fff !important;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      border-radius: 12px 12px 0 0 !important;
      padding: 14px 18px !important;
      text-align: center;
      border: none !important;
    }

    tbody tr {
      background: var(--gris-claro);
      border-radius: 12px;
      transition: background-color 0.3s ease;
      cursor: default;
    }

    tbody tr:hover {
      background-color: #dce7f5 !important;
      color: var(--azul-oscuro);
    }

    tbody td {
      vertical-align: middle !important;
      text-align: center;
      padding: 14px 12px;
      border-top: none !important;
      color: var(--texto-principal);
      font-weight: 500;
      border-radius: 8px;
    }

    .btn-enviar {
      background-color: var(--azul-suave);
      border: none;
      font-weight: 700;
      padding: 9px 22px;
      border-radius: 30px;
      box-shadow: 0 6px 14px rgba(90, 141, 189, 0.4);
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      color: white;
      user-select: none;
    }

    .btn-enviar:hover {
      background-color: var(--azul-oscuro);
      box-shadow: 0 10px 26px rgba(59, 101, 156, 0.6);
      color: white;
    }

    @media (max-width: 768px) {
      h2 {
        font-size: 1.8rem;
        margin-bottom: 30px;
      }

      thead th, tbody td {
        font-size: 0.9rem;
        padding: 10px 8px;
      }

      .filtro-container {
        max-width: 100%;
        padding: 0 15px;
      }
    }
    .filtro-container {
  max-width: 420px;
  margin: 0 0 40px 0; /* quitar centrar */
  text-align: left;
}

#tablaPedidos tbody tr td:last-child button {
  background-color: #1df933ff; 
  border: none;
  color: white;
  font-weight: 700;
  padding: 6px 14px;
  border-radius: 6px;
  transition: background-color 0.3s ease;
  cursor: pointer;
}

#tablaPedidos tbody tr td:last-child button:hover {
  background-color: #53c606ff;
}

  </style>
</head>
<body>
  <div class="container-fluid px-3 py-4" style="max-width:1100px;">
    <div class="glass-card mb-4 p-4 shadow-lg rounded-4">
      <div class="d-flex align-items-center mb-3">
        <i class="fas fa-utensils fa-2x me-3 text-primary"></i>
        <h2 class="fw-bold mb-0" style="font-size:2.3rem;letter-spacing:1.2px;background:linear-gradient(90deg,#2193b0,#6dd5ed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Pedidos en Preparación</h2>
      </div>
      <div class="row g-3 align-items-center mb-2">
        <div class="col-md-6">
          <label for="selectEvento" class="form-label fw-semibold text-primary">Filtrar por Evento:</label>
          <select id="selectEvento" class="form-select form-select-lg rounded-3 border-2 border-info bg-light shadow-sm" aria-label="Seleccionar evento">
            <option value="">-- Selecciona un evento --</option>
            <!-- Opciones cargadas por JS -->
          </select>
        </div>
      </div>
    </div>
    <div class="glass-table table-responsive p-3 rounded-4 shadow-lg" style="background:rgba(255,255,255,0.85);backdrop-filter:blur(6px);">
      <div class="card tabla-card">
        <table id="tablaPedidos" class="table table-bordered table-striped" style="border-radius:12px;overflow:hidden;background:rgba(255,255,255,0.98);box-shadow:0 2px 12px #2193b030;">
          <thead>
            <tr>
              <th style="font-weight:800;font-size:1.08rem;background:linear-gradient(90deg,#2193b0 0%,#6dd5ed 100%);color:#fff;border:none;letter-spacing:0.5px;text-shadow:0 2px 8px #2193b080;">Cliente</th>
              <th style="font-weight:800;font-size:1.08rem;background:linear-gradient(90deg,#2193b0 0%,#6dd5ed 100%);color:#fff;border:none;letter-spacing:0.5px;text-shadow:0 2px 8px #2193b080;">Fecha</th>
              <th style="font-weight:800;font-size:1.08rem;background:linear-gradient(90deg,#2193b0 0%,#6dd5ed 100%);color:#fff;border:none;letter-spacing:0.5px;text-shadow:0 2px 8px #2193b080;">Tiempo Estimado</th>
              <th style="font-weight:800;font-size:1.08rem;background:linear-gradient(90deg,#2193b0 0%,#6dd5ed 100%);color:#fff;border:none;letter-spacing:0.5px;text-shadow:0 2px 8px #2193b080;">Total</th>
              <th style="font-weight:800;font-size:1.08rem;background:linear-gradient(90deg,#2193b0 0%,#6dd5ed 100%);color:#fff;border:none;letter-spacing:0.5px;text-shadow:0 2px 8px #2193b080;">Estado</th>
              <th style="font-weight:800;font-size:1.08rem;background:linear-gradient(90deg,#2193b0 0%,#6dd5ed 100%);color:#fff;border:none;letter-spacing:0.5px;text-shadow:0 2px 8px #2193b080;">Repartidor</th>
              <th style="font-weight:800;font-size:1.08rem;background:linear-gradient(90deg,#2193b0 0%,#6dd5ed 100%);color:#fff;border:none;letter-spacing:0.5px;text-shadow:0 2px 8px #2193b080;">Acción</th>
            </tr>
          </thead>
          <tbody>
            <!-- Contenido dinámico -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <style>
    .glass-card {
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(8px);
      border: 2px solid #b2ebf2;
      box-shadow: 0 8px 32px #2193b030;
    }
    .glass-table {
      border: 2px solid #b2ebf2;
      box-shadow: 0 4px 18px #2193b030;
    }
    #tablaPedidos thead th {
      font-size: 1.08rem;
      font-weight: 800;
      letter-spacing: 0.08em;
      border: none;
      text-transform: uppercase;
      text-shadow: 0 2px 8px #2193b050;
    }
    #tablaPedidos tbody tr {
      background: #f6fbff;
      border-radius: 12px;
      transition: background-color 0.3s;
    }
    #tablaPedidos tbody tr:hover {
      background: #eaf6fb;
    }
    #tablaPedidos tbody td {
      vertical-align: middle;
      text-align: center;
      padding: 14px 12px;
      font-weight: 500;
      border-radius: 8px;
      border-top: none;
      color: #222;
      background: transparent;
    }
    .btn-enviar {
      background: linear-gradient(90deg,#43ea7b,#2dbd6e,#43ea7b);
      border: none;
      font-weight: 800;
      padding: 11px 28px;
      border-radius: 30px;
      box-shadow: 0 8px 22px #43ea7b60;
      color: #fff;
      font-size: 1.08rem;
      letter-spacing: 1px;
      text-shadow: 0 2px 8px #2dbd6e80;
      transition: background 0.3s, box-shadow 0.3s, color 0.3s;
    }
    .btn-enviar:hover {
      background: linear-gradient(90deg,#2dbd6e,#43ea7b,#2dbd6e);
      box-shadow: 0 12px 32px #2dbd6e80;
      color: #fff;
    }
    .estado-select, .repartidor-select {
      background: #fff;
      color: #222;
      font-weight: 600;
      border: 2px solid #7fc8a9;
      border-radius: 14px;
      box-shadow: 0 2px 8px #7fc8a950;
      padding: 8px 18px;
      font-size: 1rem;
      transition: background 0.3s, color 0.3s, border 0.3s;
    }
    .estado-select:focus, .repartidor-select:focus, .estado-select:active, .repartidor-select:active, .estado-select:checked, .repartidor-select:checked {
      background: linear-gradient(90deg,#43ea7b,#2dbd6e,#43ea7b);
      color: #fff;
      border-color: #2dbd6e;
      outline: none;
      box-shadow: 0 0 14px #43ea7b;
    }
    .form-select:focus {
      border-color: #2193b0;
      box-shadow: 0 0 14px #6dd5ed;
      outline: none;
      background: #eaf6fb;
      color: #2193b0;
    }
    @media (max-width: 768px) {
      .glass-card, .glass-table { padding: 8px 2px; }
      h2 { font-size: 1.5rem; }
      #tablaPedidos thead th, #tablaPedidos tbody td { font-size: 0.92rem; padding: 8px 4px; }
    }
  </style>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery-3.7.1.js"></script>
  <!-- Bootstrap 4 -->
<script src="plugins/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <!-- AdminLTE -->
  <script src="dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="../js/cocinero.js"></script>
</body>
</html>
