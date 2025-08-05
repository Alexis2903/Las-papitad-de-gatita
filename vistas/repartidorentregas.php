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
        padding: 40px 20px;
        color: var(--texto-principal);
        min-height: 100vh;
      }

      h2 {
        color: var(--azul-principal);
        text-align: center;
        font-weight: 700;
        margin-bottom: 40px;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        text-shadow: 0 1px 3px rgba(0, 123, 255, 0.3);
        user-select: none;
      }

    .glass-table {
      border: 2px solid #b2ebf2;
      box-shadow: 0 4px 18px #2193b030;
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(6px);
      border-radius: 16px;
      padding: 18px 18px;
      margin-bottom: 24px;
    }
    #tablaPedidos {
      border-radius: 12px;
      overflow: hidden;
      background: rgba(255,255,255,0.98);
      box-shadow: 0 2px 12px #2193b030;
      width: 100% !important;
    }
    #tablaPedidos thead th {
      font-weight: 800;
      font-size: 1.08rem;
      background: linear-gradient(90deg,#2193b0 0%,#6dd5ed 100%);
      color: #fff;
      border: none;
      letter-spacing: 0.5px;
      text-shadow: 0 2px 8px #2193b080;
      text-align: center;
      padding: 14px 12px;
      user-select: none;
    }
    #tablaPedidos tbody tr {
      background: #f6fbff;
      border-radius: 12px;
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
      padding: 14px 12px;
      font-weight: 500;
      border-radius: 8px;
      border-top: none;
      color: #222;
      background: transparent;
      user-select: none;
    }

      /* Pagination & info */
      .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 6px 12px;
        margin-left: 2px;
        border-radius: 6px;
        border: 1.5px solid var(--azul-principal);
        color: var(--azul-principal) !important;
        background: transparent !important;
        transition: all 0.3s ease;
        cursor: pointer;
      }
      .dataTables_wrapper .dataTables_paginate .paginate_button.current,
      .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--azul-principal) !important;
        color: var(--blanco) !important;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
      }

      /* Search box */
      .dataTables_filter input {
        border-radius: 20px !important;
        border: 1.5px solid var(--azul-principal) !important;
        padding: 6px 15px !important;
        width: 200px !important;
        transition: border-color 0.3s ease !important;
      }
      .dataTables_filter input:focus {
        border-color: var(--azul-oscuro) !important;
        box-shadow: 0 0 8px rgba(0, 86, 179, 0.4) !important;
        outline: none !important;
      }

      /* Responsive adjustments */
      @media (max-width: 768px) {
        .table-container {
          padding: 15px 15px;
        }
        h2 {
          font-size: 1.8rem;
          margin-bottom: 30px;
        }
        .dataTables_filter input {
          width: 100% !important;
        }
      }

      /* Botón ver mapa */
      .btn-ver-mapa {
        background: linear-gradient(90deg,#2193b0,#6dd5ed);
        border: none;
        color: #fff;
        padding: 11px 28px;
        border-radius: 30px;
        font-weight: 800;
        font-size: 1.08rem;
        letter-spacing: 1px;
        text-shadow: 0 2px 8px #2193b080;
        box-shadow: 0 8px 22px #2193b060;
        transition: background 0.3s, box-shadow 0.3s, color 0.3s;
        user-select: none;
        white-space: nowrap;
        margin-right: 8px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
      }
      .btn-ver-mapa:hover,
      .btn-ver-mapa:focus {
        background: linear-gradient(90deg,#6dd5ed,#2193b0);
        box-shadow: 0 12px 32px #2193b080;
        color: #2193b0;
        outline: none;
        text-decoration: none;
      }

      .btn-entregar {
        background: linear-gradient(90deg,#43ea7b,#2dbd6e,#43ea7b);
        border: none;
        color: #fff;
        font-weight: 800;
        padding: 11px 28px;
        border-radius: 30px;
        box-shadow: 0 8px 22px #43ea7b60;
        font-size: 1.08rem;
        letter-spacing: 1px;
        text-shadow: 0 2px 8px #2dbd6e80;
        transition: background 0.3s, box-shadow 0.3s, color 0.3s;
        user-select: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
      }
      .btn-entregar:hover,
      .btn-entregar:focus {
        background: linear-gradient(90deg,#2dbd6e,#43ea7b,#2dbd6e);
        box-shadow: 0 12px 32px #2dbd6e80;
        color: #2193b0;
        outline: none;
        text-decoration: none;
      }

      /* Modal styles */
      #map {
        width: 100%;
        height: 450px;
        border-radius: 12px;
        border: 1px solid #ddd;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        user-select: none;
      }
      .modal-title {
        font-weight: 700;
        color: var(--azul-principal);
        letter-spacing: 0.5px;
        user-select: none;
      }
      .btn-entregar {
  background-color: #1df933ff; /* verde fosforescente claro */
  color: #222;
  font-weight: 600;
  box-shadow: 0 4px 10px rgba(127, 255, 0, 0.6);
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.btn-entregar:hover,
.btn-entregar:focus {
  background-color: #53c606ff; /* un verde más brillante al pasar el mouse */
  box-shadow: 0 6px 20px rgba(161, 255, 58, 0.8);
  color: #111;
  outline: none;
  text-decoration: none;
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
