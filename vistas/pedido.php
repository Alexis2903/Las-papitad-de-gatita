<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: logeo.php');
    exit;
}
$id_cliente = $_SESSION['id_usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
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
   body {
  background: #f4f6f9;
  font-family: 'Nunito', sans-serif;
  margin: 0;
  padding: 12px;
  font-size: 14px;
}

.productos-carrito-wrapper {
  display: flex;
  gap: 16px;
  max-width: 1100px;
  margin: 0 auto;
  align-items: flex-start;
  flex-wrap: nowrap;
  overflow-x: hidden;
}

.productos-wrapper {
  flex: 1 1 auto;
  min-width: 0;
}

.productos-wrapper h2 {
  margin-bottom: 12px;
  color: #1976d2;
  font-weight: 700;
  font-size: 1.3rem;
}

#listaProductos {
  display: flex !important;
  flex-direction: row !important;
  gap: 6px;
  overflow-x: auto !important;
  padding-bottom: 8px;
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: thin;
  scrollbar-color: #1976d2 #f4f6f9;
}

#listaProductos::-webkit-scrollbar {
  height: 6px;
}

#listaProductos::-webkit-scrollbar-track {
  background: #f4f6f9;
  border-radius: 3px;
}

#listaProductos::-webkit-scrollbar-thumb {
  background-color: #1976d2;
  border-radius: 3px;
}

#listaProductos .producto-card {
  flex: 0 0 auto;
  width: 220px;
  padding: 8px 8px;
  border: 1.2px solid #2193b0;
  border-radius: 10px;
  background: #fff;
  box-shadow: 0 1px 4px rgba(33, 147, 176, 0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  transition: box-shadow 0.3s ease, border-color 0.3s ease;
}

#listaProductos .producto-card:hover {
  box-shadow: 0 3px 8px rgba(33, 147, 176, 0.2);
  border-color: #6dd5ed;
}

#listaProductos .producto-card img {
  width: 100%;
  max-width: 140px;
  aspect-ratio: 4/3;
  border-radius: 12px;
  object-fit: contain;
  border: 1.2px solid #2193b0;
  background: #eaf6fb;
}

#listaProductos .producto-info h5 {
  font-size: 0.9rem;
  font-weight: 700;
  color: #1e3a8a;
  text-align: center;
  margin-bottom: 4px;
}

#listaProductos .producto-info p {
  font-size: 0.75rem;
  color: #444;
  text-align: center;
  margin-bottom: 6px;
  min-height: 32px;
}

#listaProductos .producto-info button {
  width: 100%;
  font-size: 0.8rem;
  padding: 6px 10px;
  border-radius: 12px;
  font-weight: 700;
  color: white;
  background-color: #1976d2;
  border: none;
  cursor: pointer;
  transition: background-color 0.25s ease;
}

#listaProductos .producto-info button:hover {
  background-color: #125ea9;
}

@media (max-width: 768px) {
  #listaProductos .producto-card {
    width: 120px;
    padding: 8px 10px;
  }

  #listaProductos .producto-card img {
    max-width: 120px;
  }

  #listaProductos .producto-info h5 {
    font-size: 0.85rem;
  }

  #listaProductos .producto-info p {
    font-size: 0.7rem;
  }

  #listaProductos .producto-info button {
    font-size: 0.75rem;
    padding: 5px 8px;
  }
}

.carrito-container {
  width: 220px;
  background: #f1f7ff;
  border: 1.2px solid #1976d2;
  border-radius: 12px;
  padding: 14px 10px;
  box-shadow: 0 4px 14px rgba(25, 118, 210, 0.3);
  position: sticky;
  top: 15px;
  height: fit-content;
  font-size: 0.85rem;
}

.carrito-container h2 {
  font-size: 1rem;
  gap: 6px;
  margin-bottom: 10px;
}

#tablaCarrito {
  font-size: 0.85rem;
  margin-bottom: 12px;
}

#tablaCarrito th,
#tablaCarrito td {
  padding: 6px 5px;
}

#tablaCarrito input[type=number] {
  width: 50px;
  font-size: 0.8rem;
  padding: 3px 5px;
  border-radius: 5px;
  border: 1.2px solid #ccc;
}

.btn-success {
  font-size: 0.9rem;
  padding: 8px 16px;
  border-radius: 6px;
}

.btn-success:hover {
  background-color: #125ea9;
}

@media (max-width: 768px) {
  .productos-carrito-wrapper {
    flex-direction: column;
  }

  .carrito-container {
    width: 100% !important;
    margin-top: 20px;
    position: relative;
    top: auto;
  }

  #listaProductos {
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 10px;
    padding-bottom: 8px;
    overflow-x: visible;
  }

  #listaProductos .producto-card {
    max-width: 100%;
    min-width: 0;
    padding: 16px;
    gap: 12px;
    border-radius: 14px;
  }

  #listaProductos .producto-card img {
    width: 100%;
    max-width: 160px;
    aspect-ratio: 4/3;
    height: auto;
    object-fit: contain;
    margin: 0 auto 10px auto;
    border-radius: 12px;
  }

  #listaProductos .producto-info button {
    width: 100%;
  }
}

#listaProductos .producto-card {
  padding: 14px;
  border: 1.2px solid #d2d6de;
  border-radius: 12px;
  background: #f9fafb;
  box-shadow: 0 1px 4px rgba(0,0,0,0.05);
  display: flex;
  gap: 14px;
  min-height: 120px;
  transition: box-shadow 0.3s ease;
}

#listaProductos .producto-card:hover {
  box-shadow: 0 4px 12px rgba(25, 118, 210, 0.2);
}

#listaProductos .producto-card img {
  width: 100%;
  height: auto;
}

#listaProductos .producto-info button {
  width: 100%;
}

#listaEventos {
  display: flex !important;
  flex-direction: row !important;
  gap: 8px !important;
  overflow-x: auto !important;
  white-space: nowrap !important;
  padding-bottom: 8px;
  scrollbar-width: thin;
  scrollbar-color: #2193b0 #f0f8ff;
  width: 100%;
  box-sizing: border-box;
}

#listaEventos::-webkit-scrollbar {
  height: 6px;
}

#listaEventos::-webkit-scrollbar-track {
  background: #f0f8ff;
  border-radius: 3px;
}

#listaEventos::-webkit-scrollbar-thumb {
  background-color: #2193b0;
  border-radius: 3px;
}

.evento-card {
  flex: 0 0 auto !important;
  width: 180px !important;
  padding: 8px 10px !important;
  border: 1.2px solid #2193b0 !important;
  border-radius: 10px !important;
  background-color: #f0f8ff !important;
  cursor: pointer !important;
  box-shadow: 0 2px 10px rgba(33,147,176,0.15) !important;
  transition: box-shadow 0.3s ease !important;
  display: inline-block !important;
}

.evento-card:hover {
  box-shadow: 0 4px 16px rgba(33,147,176,0.3) !important;
}

.evento-card h4 {
  font-size: 0.9rem !important;
  color: #2193b0 !important;
  margin-bottom: 6px !important;
}

.evento-card button {
  font-size: 0.8rem !important;
  padding: 5px 8px !important;
  width: 100% !important;
}

  </style>
</head>
<body class="hold-transition layout-top-nav">
  <div class="wrapper">
    <div class="content-wrapper">
      <div class="main-container">
        <div class="productos-carrito-wrapper">
          <div class="productos-wrapper">
            <h2><i class="fas fa-calendar-alt"></i> Eventos disponibles</h2>
            <div id="listaEventos" class="mb-4"></div>
            
            <h2><i></i> Para ver mas productos use la flecha a la derecha ---></h2>


            <div id="listaProductos"></div>
          </div>

          <aside class="carrito-container">
            <h2><i class="fas fa-shopping-cart"></i> Carrito</h2>

            <!-- Aquí podrías agregar info extra o eventos relacionados al carrito si deseas -->
            <table id="tablaCarrito" class="table table-sm table-bordered">
              <thead>
                <tr><th>Nombre</th><th>Cantidad</th></tr>
              </thead>
              <tbody></tbody>
            </table>

            <button class="btn btn-success" onclick="enviarPedido()">
              <i class="fas fa-check-circle"></i> Realizar Pedido
            </button>
          </aside>
        </div>
      </div>
    </div>
  </div>

<script>
  const id_cliente = <?= json_encode($id_cliente); ?>;
</script>

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
  <script src="../js/pedido.js"></script>
</body>
</html>
