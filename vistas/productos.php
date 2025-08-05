<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestión de Productos</title>

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
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

 <style>
    :root {
      --azul-principal: #357ABD;
      --azul-oscuro: #2a5e91;
      --azul-claro: #6dd5ed;
      --blanco: #fff;
      --gris-fondo: #f9fafb;
      --sombra-suave: rgba(53, 122, 189, 0.15);
      --glass-blur: blur(14px);
      --glass-shadow: 0 8px 32px 0 rgba(53,122,189,0.18);
      --color-acento: #2193b0;
      --color-acento-hover: #357ABD;
      --color-blanco: #fff;
      --color-fondo: #f9fafb;
      --texto-principal: #34495e;
      --texto-secundario: #6c757d;
      --borde-input: #b2ebf2;
      --fondo-input: #f4f8fb;
    }

    body {
      font-family: 'Nunito', 'Rubik', sans-serif !important;
      min-height: 100vh;
      background: linear-gradient(135deg, #fefefeff 0%, #fefefeff 100%);
      color: var(--texto-principal);
      margin: 0;
      padding: 0;
      position: relative;
      overflow-x: hidden;
    }
    body::before {
      content: '';
      position: absolute;
      top: -120px; left: -120px;
      width: 340px; height: 340px;
      background: radial-gradient(circle, #fefefeff 60%, #fefefeff 100%);
      opacity: 0.18;
      border-radius: 50%;
      z-index: 0;
    }
    body::after {
      content: '';
      position: absolute;
      bottom: -100px; right: -100px;
      width: 260px; height: 260px;
      background: radial-gradient(circle, #6dd5ed 60%, #2193b0 100%);
      opacity: 0.15;
      border-radius: 50%;
      z-index: 0;
    }

    .main-wrapper {
  max-width: 1100px;
  margin: 38px auto 18px auto;
  background: transparent !important;  /* quitar fondo */
  border-radius: 0 !important;         /* quitar bordes redondeados */
  box-shadow: none !important;         /* quitar sombra */
  backdrop-filter: none !important;    /* quitar efecto blur */
  padding: 0;                          /* quitar padding para que no haya espacio extra */
  position: relative;
  z-index: 1;
  animation: none;                     /* quitar animación */
}


    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

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

    #formProducto {
      background: rgba(255,255,255,0.98);
      box-shadow: 0 4px 25px var(--sombra-suave);
      border-radius: 18px;
      padding: 28px 32px;
      backdrop-filter: blur(8px);
      border: 1.5px solid #b2ebf2;
    }

/* === NUEVO DISEÑO MEJORADO Y COMPACTO PARA EL FORMULARIO === */

:root {
  /* Variables consistentes con las plantillas */
  --azul-resaltado: #0d6efd;
  --blanco-puro: #ffffff;
  --fondo-claro: #f8f9fa; /* Un gris muy sutil para los inputs */
  --borde-suave: #dee2e6;
  --texto-oscuro: #212529;
  --texto-secundario: #6c757d;
  --duracion-transicion: 0.2s;
}

#formProducto {
  background: var(--blanco-puro);
  border: 1px solid var(--borde-suave);
  box-shadow: 0 10px 30px rgba(0,0,0,0.07); /* Sombra más pronunciada para destacar */
  border-radius: 16px;
  padding: 2rem;
  backdrop-filter: none;
}

/* Estilo para todas las etiquetas (labels) dentro del formulario */
#formProducto label {
  color: var(--texto-secundario);
  font-weight: 500;
  margin-bottom: .5rem;
  font-size: 0.9rem;
}

/* Estilo unificado para todos los campos de entrada */
#formProducto .form-control,
#formProducto .form-select, /* Bootstrap 5 usa form-select */
#formProducto select.form-control { /* Compatibilidad con versiones anteriores */
  border: 1px solid var(--borde-suave);
  border-radius: 8px;
  color: var(--texto-oscuro);
  font-weight: 500;
  background-color: var(--fondo-claro);
  box-shadow: none;
  transition: border-color var(--duracion-transicion) ease, box-shadow var(--duracion-transicion) ease;
}
#formProducto .form-control-file { /* Estilo específico para el input de archivo */
    border: 1px solid var(--borde-suave);
    border-radius: 8px;
    padding: .5rem .75rem;
}

#formProducto .form-control::placeholder,
#formProducto textarea::placeholder {
  color: #adb5bd;
  font-style: normal;
}

/* Efecto de foco para todos los campos */
#formProducto .form-control:focus,
#formProducto .form-select:focus,
#formProducto select:focus {
  border-color: var(--azul-resaltado);
  box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
  background-color: var(--blanco-puro);
}

/* Botón de Guardar */
#btnGuardar {
  background: var(--azul-resaltado);
  border: none;
  font-weight: 600;
  font-size: 1rem;
  width: 100%;
  padding: .85rem 1rem;
  color: var(--blanco-puro);
  border-radius: 8px;
  margin-top: 1rem; /* Espacio antes del botón */
  box-shadow: 0 4px 14px 0 rgba(13, 110, 253, 0.3);
  transition: all var(--duracion-transicion) ease;
  letter-spacing: 0.5px;
}

#btnGuardar:hover {
  background: #0b5ed7; /* Azul más oscuro */
  transform: translateY(-2px);
  box-shadow: 0 6px 16px 0 rgba(13, 110, 253, 0.4);
}

/* Estructura del formulario en filas usando Bootstrap (esto requiere que el HTML use 'row' y 'col') */
#formProducto .row > [class*='col-'] {
    margin-bottom: 1rem;
}

    .card.tabla-card {
      border-radius: 18px;
      box-shadow: 0 0 30px var(--sombra-suave);
      background: rgba(255,255,255,0.98);
      padding: 28px 18px;
      margin-top: 18px;
      backdrop-filter: blur(8px);
      border: 1.5px solid #b2ebf2;
    }

    #tabla {
      font-size: 1rem !important;
      width: 100% !important;
      border-radius: 12px;
      overflow: hidden;
      background: rgba(255,255,255,0.98);
      box-shadow: 0 2px 12px #2193b030;
    }

    #tabla thead th {
      font-weight: 800;
      font-size: 1.08rem;
      background: linear-gradient(90deg, #2193b0 0%, #6dd5ed 100%);
      color: var(--color-blanco);
      border: none;
      letter-spacing: 0.5px;
      text-shadow: 0 2px 8px #2193b080;
    }

    #tabla tbody tr:hover {
      background-color: #d9e7f7 !important;
      cursor: pointer;
      transition: background 0.3s;
    }

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

    @media (max-width: 768px) {
      .main-wrapper {
        margin: 12px 2px;
        padding: 12px 2px;
        border-radius: 12px;
      }
      h2 {
        font-size: 1.3rem;
        margin-bottom: 18px;
      }
      .form-container {
        margin-bottom: 18px;
      }
      #formProducto {
        padding: 12px 8px;
        border-radius: 10px;
      }
      #btnGuardar {
        font-size: 0.98rem;
        padding: 10px;
        border-radius: 10px;
      }
      .card.tabla-card {
        padding: 12px 4px;
        border-radius: 10px;
      }
      #tabla {
        border-radius: 8px;
      }
    }
  </style>

</head>
<body class="hold-transition sidebar-mini">
  <div class="main-wrapper">
    <h2>Gestión de Productos</h2>
   <!-- === FORMULARIO RECOMENDADO (REEMPLAZAR EN EL HTML) === -->
<div class="form-container">
  <form id="formProducto" enctype="multipart/form-data" class="card">
    <input type="hidden" name="id_producto" id="id_producto" />
    <input type="hidden" name="imagen_actual" id="imagen_actual" />

    <!-- Fila 1 -->
    <div class="row">
      <div class="col-md-6">
        <label for="tipo_producto">Tipo de Producto</label>
        <select id="tipo_producto" name="tipo_producto" class="form-select">
          <option value="Normal">Producto Normal</option>
          <option value="Evento">Producto de Evento</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="nombre">Nombre del Producto</label>
        <input type="text" name="nombre" id="nombre" placeholder="Ej: Hamburguesa Doble" class="form-control" />
        <div id="error-nombre" class="text-danger small mt-1"></div>
      </div>
    </div>

    <!-- Campos de Evento (se muestran/ocultan con JS) -->
    <div id="grupo_evento_existente" style="display:none;" class="mb-3">
      <label for="evento_existente">Seleccionar Evento Existente (opcional)</label>
      <select id="evento_existente" class="form-select">
          <option value="">-- Autocompletar con evento existente --</option>
      </select>
    </div>
    <div class="row">
        <div class="col-md-8" id="grupo_evento" style="display:none;">
          <label for="nombre_evento">Nombre del Evento (si es nuevo)</label>
          <input type="text" name="nombre_evento" id="nombre_evento" placeholder="Ej: Festival de Verano" class="form-control" />
          <div id="error-nombre_evento" class="text-danger small mt-1"></div>
        </div>
        <div class="col-md-4" id="grupo_fecha_evento" style="display:none;">
          <label for="fecha_evento">Fecha</label>
          <input type="date" name="fecha_evento" id="fecha_evento" class="form-control" />
          <div id="error-fecha_evento" class="text-danger small mt-1"></div>
        </div>
    </div>
    
    <div class="mb-3">
      <label for="descripcion">Descripción</label>
      <textarea name="descripcion" id="descripcion" placeholder="Breve descripción del producto..." class="form-control" rows="2"></textarea>
      <div id="error-descripcion" class="text-danger small mt-1"></div>
    </div>
    
    <div class="row">
      <div class="col-md-6">
        <label for="precio">Precio ($)</label>
        <input type="number" name="precio" id="precio" placeholder="Ej: 9.99" class="form-control" step="0.01" />
        <div id="error-precio" class="text-danger small mt-1"></div>
      </div>
      <div class="col-md-6">
        <label for="tiempo_preparacion">Tiempo de Preparación (min)</label>
        <input type="number" name="tiempo_preparacion" id="tiempo_preparacion" placeholder="Ej: 20" class="form-control" />
        <div id="error-tiempo_preparacion" class="text-danger small mt-1"></div>
      </div>
    </div>

    <div class="mb-3">
      <label for="imagen">Imagen del Producto</label>
      <input type="file" name="imagen" id="imagen" class="form-control" />
      <div id="error-imagen" class="text-danger small mt-1"></div>
    </div>

    <button type="button" class="btn" id="btnGuardar">Guardar</button>
  </form>
</div>
<!-- ======================================================= -->
    <div class="card tabla-card">
      <table id="tabla" class="table table-bordered table-striped"></table>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- JS externo -->
  <script src="../js/productos.js?v=<?= time() ?>"></script>
</body>
</html>
