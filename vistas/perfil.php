<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: logeo.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Mi Perfil</title>

  <!-- Bootstrap 5 CSS CDN -->
<link rel="stylesheet" href="plugins/bootstrap-5.3.7/css/bootstrap.min.css" />

  <!-- FontAwesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

  <style>
    html, body {
      height: 100%;
      margin: 0;
      background-color: #f8f9fa;
      font-family: "Source Sans Pro", sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      box-sizing: border-box;
      height: 100vh;
    }

    .profile-card {
      max-width: 420px;
      width: 100%;
      background: white;
      border-radius: 0.5rem;
      box-shadow: 0 0.3rem 0.6rem rgba(0,0,0,0.12);
      padding: 1.5rem 2rem;
      display: flex;
      align-items: center;
      gap: 1.8rem;
      text-align: left;
      transition: box-shadow 0.3s ease;
    }

    .profile-card:hover {
      box-shadow: 0 0.6rem 1rem rgba(0,0,0,0.18);
    }

    .profile-img {
      width: 110px;
      height: 110px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #17a2b8;
      transition: transform 0.3s ease;
      flex-shrink: 0;
    }

    .profile-img:hover {
      transform: scale(1.07);
    }

    .profile-info {
      flex: 1;
    }

    .profile-info h3 {
      margin-bottom: 0.3rem;
      font-weight: 700;
      font-size: 1.35rem;
      color: #212529;
    }

    .profile-info small {
      color: #6c757d;
      display: block;
      margin-bottom: 1.1rem;
      font-size: 0.95rem;
      font-style: italic;
    }

    .profile-row {
      display: flex;
      margin-bottom: 0.7rem;
      font-weight: 600;
      color: #495057;
      font-size: 0.9rem;
    }

    .profile-label {
      flex: 0 0 35%;
    }

    .profile-value {
      flex: 1;
      font-weight: 400;
      color: #212529;
    }

    .btn-info {
      margin-top: 1.2rem;
      padding: 0.5rem 1.4rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
      font-size: 0.95rem;
      border-radius: 0.3rem;
      cursor: pointer;
    }

    .btn-info i {
      font-size: 1.1rem;
    }
  </style>
</head>
<body>

  <div class="profile-card shadow-sm">
    <img src="dist/img/logo.png" alt="Foto de Perfil" class="profile-img" />
    <div class="profile-info">
      <h3 id="ver_usuario"></h3>
      <small id="ver_rol"></small>

      <div class="profile-row">
        <div class="profile-label">Nombres:</div>
        <div class="profile-value" id="ver_nombres"></div>
      </div>
      <div class="profile-row">
        <div class="profile-label">Apellidos:</div>
        <div class="profile-value" id="ver_apellidos"></div>
      </div>
      <div class="profile-row">
        <div class="profile-label">Teléfono:</div>
        <div class="profile-value" id="ver_telefono"></div>
      </div>

      <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalEditarPerfil">
        <i class="fas fa-edit"></i> Editar Perfil
      </button>
    </div>
  </div>

  <!-- Modal Editar Perfil -->
  <div class="modal fade" id="modalEditarPerfil" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="formPerfil" novalidate>
          <div class="modal-header bg-info text-white">
            <h5 class="modal-title" id="modalEditarLabel"><i class="fas fa-user-edit me-2"></i>Editar Perfil</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nombres" class="form-label">Nombres</label>
              <input type="text" class="form-control" id="nombres" name="nombres" required />
            </div>
            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text" class="form-control" id="apellidos" name="apellidos" required />
            </div>
            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <input type="text" class="form-control" id="telefono" name="telefono" required />
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">
              <i class="fas fa-save me-2"></i>Guardar Cambios
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <!-- Bootstrap 5 Bundle JS (Popper + Bootstrap JS) -->
<script src="plugins/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="../js/perfil.js"></script>

</body>
</html>
