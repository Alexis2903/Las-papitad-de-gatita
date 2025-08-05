  <?php
  session_start();
  if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'repartidor') {
      header("Location: logeo.php"); 
      exit();
  }
  ?>
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8" />
    <title>Pedidos para el Repartidor</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700&display=fallback" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
    <!-- AdminLTE -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css" />
    <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="plugins/bootstrap-5.3.7/css/bootstrap.min.css" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

    <style>
      :root {
        /* Tus colores originales se mantienen intactos */
        --azul-principal: #007bff;
        --azul-oscuro: #0056b3;
        --gris-fondo: #eef2f7;
        --blanco: #fff;
        --sombra-suave: rgba(0, 123, 255, 0.15);
        --texto-principal: #34495e;
      }

      body {
        background-color: var(--gris-fondo);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding: 20px; /* Reducido */
        color: var(--texto-principal);
        min-height: 100vh;
      }

      h2 {
        color: var(--azul-principal);
        text-align: center;
        font-weight: 700;
        margin-bottom: 25px; /* Reducido */
        text-transform: uppercase;
        letter-spacing: 1px; /* Reducido */
        font-size: 1.7rem; /* Reducido */
        text-shadow: 0 1px 3px rgba(0, 123, 255, 0.3);
        user-select: none;
      }

    .glass-table {
      border: 2px solid #b2ebf2;
      box-shadow: 0 4px 18px #2193b030;
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(6px);
      border-radius: 12px; /* Reducido */
      padding: 15px; /* Reducido */
      margin-bottom: 20px; /* Reducido */
    }
    #tablaPedidos {
      border-radius: 10px; /* Reducido */
      overflow: hidden;
      background: rgba(255,255,255,0.98);
      box-shadow: 0 2px 12px #2193b030;
      width: 100% !important;
    }
    #tablaPedidos thead th {
      font-weight: 700; /* Ligeramente reducido */
      font-size: 0.9rem; /* Reducido */
      background: linear-gradient(90deg,#2193b0 0%,#6dd5ed 100%);
      color: #fff;
      border: none;
      letter-spacing: 0.5px;
      text-shadow: 0 1px 4px #2193b080; /* Reducido */
      text-align: center;
      padding: 10px 8px; /* Reducido */
      user-select: none;
    }
    #tablaPedidos tbody tr {
      background: #f6fbff;
      transition: background-color 0.3s;
      cursor: pointer;
    }
    #tablaPedidos tbody tr:hover {
      background: #eaf6fb;
      color: #2193b0;
    }
    #tablaPedidos tbody td {
      vertical-align: middle !important;
      text-align: center;
      padding: 10px 8px; /* Reducido */
      font-weight: 500;
      font-size: 0.95rem; /* Añadido para controlar tamaño */
      border-top: none;
      color: #222;
      background: transparent;
      user-select: none;
    }

      /* Pagination & info */
      .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 11px; /* Reducido */
        margin-left: 2px;
        border-radius: 6px;
        border: 1px solid var(--azul-principal); /* Reducido grosor */
        color: var(--azul-principal) !important;
        background: transparent !important;
        transition: all 0.3s ease;
        cursor: pointer;
      }
      .dataTables_wrapper .dataTables_paginate .paginate_button.current,
      .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--azul-principal) !important;
        color: var(--blanco) !important;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3); /* Reducido */
      }

      /* Search box */
      .dataTables_filter input {
        border-radius: 20px !important;
        border: 1px solid var(--azul-principal) !important; /* Reducido grosor */
        padding: 5px 12px !important; /* Reducido */
        width: 180px !important; /* Reducido */
        transition: border-color 0.3s ease !important;
      }
      .dataTables_filter input:focus {
        border-color: var(--azul-oscuro) !important;
        box-shadow: 0 0 6px rgba(0, 86, 179, 0.4) !important; /* Reducido */
        outline: none !important;
      }

      /* Responsive adjustments */
      @media (max-width: 768px) {
        body {
            padding: 10px;
        }
        .glass-table {
          padding: 10px;
        }
        h2 {
          font-size: 1.5rem;
          margin-bottom: 20px;
        }
        .dataTables_filter input {
          width: 100% !important;
        }
      }

      /* Botones de acción (Mapa y Entregar) */
      .btn-ver-mapa, .btn-entregar {
        padding: 7px 18px; /* Reducido */
        border-radius: 20px; /* Reducido */
        font-weight: 700; /* Reducido */
        font-size: 0.85rem; /* Reducido */
        letter-spacing: 0.5px; /* Reducido */
        border: none;
        color: #fff;
        transition: background 0.3s, box-shadow 0.3s, color 0.3s;
        user-select: none;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 6px; /* Reducido */
      }
      
      .btn-ver-mapa {
        background: linear-gradient(90deg,#2193b0,#6dd5ed);
        text-shadow: 0 1px 4px #2193b080; /* Reducido */
        box-shadow: 0 6px 18px #2193b060; /* Reducido */
        margin-right: 8px;
      }
      .btn-ver-mapa:hover,
      .btn-ver-mapa:focus {
        background: linear-gradient(90deg,#6dd5ed,#2193b0);
        box-shadow: 0 8px 25px #2193b080; /* Reducido */
        color: #fff; /* Se cambió para que no desaparezca el texto */
        outline: none;
        text-decoration: none;
      }

      .btn-entregar {
        background: linear-gradient(90deg,#43ea7b,#2dbd6e,#43ea7b);
        text-shadow: 0 1px 4px #2dbd6e80; /* Reducido */
        box-shadow: 0 6px 18px #43ea7b60; /* Reducido */
      }
      .btn-entregar:hover,
      .btn-entregar:focus {
        background: linear-gradient(90deg,#2dbd6e,#43ea7b,#2dbd6e);
        box-shadow: 0 8px 25px #2dbd6e80; /* Reducido */
        color: #fff; /* Se cambió para que no desaparezca el texto */
        outline: none;
        text-decoration: none;
      }

      /* Modal styles */
      #map {
        width: 100%;
        height: 400px; /* Reducido */
        border-radius: 10px; /* Reducido */
        border: 1px solid #ddd;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1); /* Reducido */
        user-select: none;
      }
      .modal-title {
        font-weight: 600; /* Reducido */
        color: var(--azul-principal);
        letter-spacing: 0.5px;
        user-select: none;
      }
</style>
  </head>
  <body>

    <h2><i class="fas fa-motorcycle"></i> Pedidos para el Repartidor</h2>

    <div class="glass-table">
      <div class="table-responsive">
        <table id="tablaPedidos" class="table table-bordered table-striped" style="width:100%">
         <thead>
  <tr>
    <th>Cliente</th>
    <th>Teléfono</th>
    <th>Total</th>
    <th>Mapa</th>
    <th>Tiempo Demora</th>
    <th>Pago Viaje</th>
    <th>Entregar</th>
  </tr>
</thead>



          <tbody>
            <!-- Aquí se llenará dinámicamente -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal para mapa -->
    <div class="modal fade" id="modalMapa" tabindex="-1" aria-labelledby="modalMapaLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content p-4">
          <h5 id="modalMapaLabel" class="modal-title mb-4">📍 Ubicación del pedido</h5>
          <div id="map"></div>
        </div>
      </div>
    </div>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery-3.7.1.js"></script>
    <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- AdminLTE -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbkY5MCRNdfvmCZrifDCB8SSm-HDAlxeA&libraries=places"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../js/repartidor.js?v=<?= time() ?>"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
      $(document).ready(function() {
        $('#tablaPedidos').DataTable({
          responsive: true,
          autoWidth: false,
          language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_ pedidos",
            paginate: {
              previous: "Anterior",
              next: "Siguiente"
            },
            zeroRecords: "No se encontraron pedidos",
            infoEmpty: "No hay pedidos disponibles",
            infoFiltered: "(filtrado de _MAX_ pedidos totales)"
          },
          columnDefs: [
            { orderable: false, targets: 3 } // La columna de acciones no es ordenable
          ]
        });
      });
    </script>

  </body>
  </html>
