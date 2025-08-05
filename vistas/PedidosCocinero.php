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
      /* Tus colores originales se mantienen intactos */
      --gris-claro: #f8f9fa;
      --blanco: #ffffff;
      --texto-principal: #34495e;
      --texto-oscuro-contraste: #212529;
      --color-grad-1: #2193b0;
      --color-grad-2: #6dd5ed;
      --color-verde-1: #43ea7b;
      --color-verde-2: #2dbd6e;
    }

    body {
      font-family: 'Nunito', sans-serif;
      background-color: var(--gris-claro);
      color: var(--texto-principal);
      padding: 20px;
    }

    /* --- CONTENEDORES CON BORDES RECTOS --- */
    .glass-card, .glass-table {
        background: rgba(255,255,255,0.9);
        border: 1px solid #e0e7ee;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 1.25rem;
        border-radius: 0; /* Bordes Rectos */
    }

    .glass-card h2 {
      font-size: 1.6rem; /* Reducido */
      letter-spacing: 0.5px;
      margin-bottom: 0 !important;
    }
    
    label[for="selectEvento"] {
        font-weight: 600;
        color: var(--color-grad-1);
    }
    
    /* --- FORMULARIOS CON BORDES RECTOS --- */
    .form-select {
        border-radius: 0; /* Bordes Rectos */
        padding: 0.4rem 0.8rem; /* Compacto */
        font-size: 0.9rem; /* Compacto */
        border: 1px solid #ced4da;
    }
    .form-select:focus {
        border-color: var(--color-grad-1);
        box-shadow: 0 0 0 2px rgba(33, 147, 176, 0.25);
    }

    /* --- TABLA CON BORDES RECTOS Y COMPACTA --- */
    #tablaPedidos {
      border-collapse: collapse !important; /* Colapsado para un look más filoso */
      width: 100% !important;
    }

    #tablaPedidos thead th {
      font-weight: 700;
      font-size: 0.8rem; /* Más pequeño */
      background: linear-gradient(90deg, var(--color-grad-1) 0%, var(--color-grad-2) 100%);
      color: var(--blanco);
      border: none;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 10px 8px; /* Compacto */
      border-radius: 0; /* Bordes Rectos */
    }
    
    #tablaPedidos tbody tr {
      background: var(--blanco);
      border-bottom: 1px solid #eff2f5; /* Línea separadora en lugar de sombra */
      transition: background-color 0.2s ease;
    }
    #tablaPedidos tbody tr:last-child {
      border-bottom: none;
    }
    #tablaPedidos tbody tr:hover {
      background: #f5faff;
    }

    #tablaPedidos tbody td {
      vertical-align: middle !important;
      text-align: center;
      padding: 10px 8px; /* Compacto */
      font-weight: 500;
      font-size: 0.85rem; /* Más pequeño */
      color: var(--texto-principal);
      border: none;
    }
    
    .estado-select, .repartidor-select {
        font-weight: 600;
        padding: 5px 10px; /* Compacto */
        font-size: 0.8rem; /* Compacto */
        border-radius: 0; /* Bordes Rectos */
        border: 1px solid #ccc;
        background-color: var(--blanco);
    }
    
    .estado-select:focus, .repartidor-select:focus,
    .estado-select:active, .repartidor-select:active {
        background: linear-gradient(90deg, var(--color-verde-1), var(--color-verde-2));
        color: var(--texto-oscuro-contraste); /* Texto oscuro para legibilidad */
        border-color: var(--color-verde-2);
        outline: none;
        box-shadow: none;
    }
    
    /* --- BOTÓN RECTO Y MUCHO MÁS PEQUEÑO --- */
    .btn-enviar {
      background: linear-gradient(90deg, var(--color-verde-1), var(--color-verde-2));
      border: none;
      font-weight: 700;
      padding: 5px 14px; /* Muy compacto */
      border-radius: 0; /* Bordes Rectos */
      box-shadow: 0 2px 8px #2dbd6e50;
      color: var(--blanco);
      font-size: 0.8rem; /* Muy compacto */
      letter-spacing: 0.5px;
      transition: all 0.2s ease;
    }
    .btn-enviar:hover {
      box-shadow: 0 4px 12px #2dbd6e60;
      transform: translateY(-1px);
      color: var(--blanco);
    }
    
    /* --- RESPONSIVE SIN CAMBIOS, YA FUNCIONABA BIEN --- */
    @media (max-width: 768px) {
      body {
        padding: 10px;
      }
      .glass-card, .glass-table { 
        padding: 1rem;
      }
      .glass-card h2 {
        font-size: 1.5rem;
      }
      #tablaPedidos thead {
        display: none;
      }
      #tablaPedidos, #tablaPedidos tbody, #tablaPedidos tr, #tablaPedidos td {
        display: block;
        width: 100%;
      }
      #tablaPedidos tr {
        margin-bottom: 15px;
        border: 1px solid #e0e7ee;
      }
      #tablaPedidos td {
        text-align: right;
        padding-left: 50%;
        position: relative;
        border-bottom: 1px solid #f0f0f0;
      }
      #tablaPedidos td:last-child {
        border-bottom: none;
      }
      #tablaPedidos td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        width: calc(50% - 20px);
        padding-right: 10px;
        white-space: nowrap;
        text-align: left;
        font-weight: 700;
        color: var(--color-grad-1);
      }
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
