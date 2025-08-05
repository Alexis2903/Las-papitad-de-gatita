<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Historial de Entregas</title>

  <!-- Bootstrap 4 -->
<link rel="stylesheet" href="plugins/bootstrap-5.3.7/css/bootstrap.min.css" />
  <!-- FontAwesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <!-- DataTables Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />

  <!-- Google Fonts Rubik -->
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;600&display=swap" rel="stylesheet" />

  <style>
   :root {
  --color-fondo: #ffffff;
  --color-blanco: #fff;
  --color-acento: #7da6cc; /* azul suave */
  --color-acento-hover: #6791bb;
  --texto-principal: #4a5a6a;
  --texto-secundario: #7a8a99;
  --borde-input: #cbd6e2;
  --sombra-suave: rgba(125, 166, 204, 0.15);
  --error-color: #e07a5f;
}

body, .wrapper, .content-wrapper, section.content, #contenedorTabla {
  padding-left: 0 !important;
  padding-right: 0 !important;
  margin-left: 0 !important;
  margin-right: 0 !important;
  max-width: 100% !important;
  width: 100% !important;
  background-color: var(--color-fondo);
  font-family: 'Rubik', sans-serif !important;
  color: var(--texto-principal);
  min-height: 100vh;
  font-size: 0.85rem; /* fuente base más pequeña */
}

h2 {
  font-weight: 600;
  font-size: 1.5rem; /* tamaño reducido */
  color: var(--color-acento);
  text-align: center;
  margin-bottom: 20px; /* margen más pequeño */
  letter-spacing: 0.5px;
  user-select: none;
}

.filtros {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 10px; /* menos espacio entre elementos */
  margin: 0 auto 20px; /* margen inferior más pequeño */
  align-items: center;
  max-width: 100%;
  padding: 0 10px;
}

.filtros > div {
  display: flex;
  align-items: center;
  gap: 8px; /* menos espacio */
  flex: 1 1 250px; /* ancho base un poco menor */
  min-width: 180px;
}

.filtros label {
  font-weight: 600;
  color: var(--color-acento);
  margin: 0;
  white-space: nowrap;
  user-select: none;
  font-size: 0.9rem; /* tamaño más pequeño */
}

#fechaFiltro {
  width: 160px;
  border-radius: 6px;
  border: 1.5px solid var(--borde-input);
  padding: 6px 10px; /* padding más pequeño */
  font-size: 0.9rem;
  color: var(--texto-principal);
  background-color: #f9fafb;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  box-shadow: inset 0 0 6px #e4e9f0;
}

#fechaFiltro:focus {
  border-color: var(--color-acento);
  box-shadow: 0 0 10px var(--color-acento);
  outline: none;
  background-color: #eef5fb;
}

#btnFiltrar, #btnPdf {
  padding: 6px 14px;
  border-radius: 6px;
  font-weight: 600;
  font-size: 0.9rem;
  user-select: none;
  transition: background-color 0.3s ease;
  cursor: pointer;
  box-shadow: 0 3px 10px var(--sombra-suave);
  flex-shrink: 0;
}

#btnFiltrar {
  background-color: var(--color-acento);
  border: none;
  color: var(--color-blanco);
}

#btnFiltrar:hover {
  background-color: var(--color-acento-hover);
}

#btnPdf {
  background-color: #dc3545;
  color: var(--color-blanco);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

#btnPdf:hover {
  background-color: #b32a3a;
  text-decoration: none;
  color: var(--color-blanco);
}

#btnPdf i {
  font-size: 1rem; /* icono un poco más pequeño */
}

#error-fechaFiltro {
  color: var(--error-color);
  font-size: 0.75rem;
  margin-top: 4px;
  display: none;
}

label[for="fechaFiltro"].todos-reportes {
  font-weight: 600;
  color: var(--color-acento);
  margin: 20px auto 10px;
  max-width: 100%;
  display: block;
  user-select: none;
  padding-left: 10px;
  font-size: 0.9rem;
}
/* Elimina los padding y margin 0 !important que tenías */
body, .wrapper, .content-wrapper, section.content {
   font-size: 0.8rem; /* un poco más pequeño que antes */
  padding-left: 10px !important;  /* espacio a los lados */
  padding-right: 15px !important;
  margin-left: auto !important;
  margin-right: auto !important;
  max-width: 1200px !important; /* limita el ancho total para que no se extienda demasiado */
  width: 100% !important;
  background-color: var(--color-fondo);
  font-family: 'Rubik', sans-serif !important;
  color: var(--texto-principal);
  min-height: 100vh;
  font-size: 0.85rem;
}

/* Contenedor tabla */
#contenedorTabla {
  max-width: 100%;
  margin: 0 auto 30px;
  background: var(--color-blanco);
  padding: 20px 20px; /* padding generoso para que la tabla no toque los bordes */
  border-radius: 10px;
  box-shadow: 0 0 20px var(--sombra-suave);
  overflow-x: auto;
  font-size: 0.9rem;
}

/* Opcional: Limita ancho máximo de la tabla para que no se extienda mucho */
#tablaEntregas {
  max-width: 1100px;
  margin-left: auto;
  margin-right: auto;
  font-size: 1rem !important;
  border-radius: 12px;
  overflow: hidden;
  background: rgba(255,255,255,0.98);
  box-shadow: 0 2px 12px #2193b030;
}

/* Responsive sigue igual */
@media (max-width: 600px) {
  .filtros {
    flex-direction: column;
    align-items: stretch;
    padding: 0 15px;
  }
  .filtros > div {
    flex: 1 1 100%;
  }
  #btnFiltrar, #btnPdf {
    width: 100%;
    text-align: center;
  }
  #contenedorTabla {
    padding: 10px 8px;
  }
}


  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content pt-4">
        <h2>📦 Historial de Entregas</h2>
        <h2 style="color: #2193b0; font-weight: 800; text-align: center; margin-bottom: 32px; font-size: 2.1rem; letter-spacing: 1px;">Gestión entregas</h2>

        <div class="filtros">
          <div>
            <label for="fechaFiltro" style="user-select:none;">
              <i class="fas fa-info-circle"></i> Día específico que desea generar:
            </label>
            <input type="date" id="fechaFiltro" class="form-control" />
            <div id="error-fechaFiltro" class="text-danger small"></div>
          </div>

          <button id="btnFiltrar" class="btn btn-primary">
            <i class="fas fa-search"></i> Buscar día
          </button>

          <a href="../ajax/reporte_entregas.php" target="_blank" id="btnPdf" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Generar PDF
          </a>
        </div>

        <label for="fechaFiltro" class="todos-reportes">
          TODOS LOS REPORTES:
        </label>

        <div id="contenedorTabla"></div>
        <style>
        /* Tabla con diseño igual a productos */
        #tablaEntregas {
          font-size: 1rem !important;
          width: 100% !important;
          border-radius: 12px;
          overflow: hidden;
          background: rgba(255,255,255,0.98);
          box-shadow: 0 2px 12px #2193b030;
        }
        #tablaEntregas thead th {
          font-weight: 800;
          font-size: 1.08rem;
          background: linear-gradient(90deg, #2193b0 0%, #6dd5ed 100%);
          color: #fff;
          border: none;
          letter-spacing: 0.5px;
          text-shadow: 0 2px 8px #2193b080;
        }
        #tablaEntregas tbody tr:hover {
          background-color: #d9e7f7 !important;
          cursor: pointer;
          transition: background 0.3s;
        }
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
          font-size: 0.9rem;
          padding: 5px 8px;
          border-radius: 10px;
          border: 1.5px solid #6dd5ed;
          background-color: #eaf6fb;
          font-weight: 500;
          box-shadow: inset 0 0 6px #e4e9f0;
          transition: border-color 0.3s ease, box-shadow 0.3s ease;
          color: #000000;
        }
        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
          border-color: #2193b0;
          box-shadow: 0 0 10px #2193b0;
          background-color: #eef5fb;
          outline: none;
        }
        </style>
      </section>
    </div>
  </div>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery-3.7.1.js"></script>
  <!-- Bootstrap 4 -->
<script src="plugins/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <!-- AdminLTE -->
  <script src="dist/js/adminlte.min.js"></script>

  <script src="../js/entrega.js"></script>
</body>
</html>
