$(document).ready(function () {
  function cargarPerfil() {
    $.get("../ajax/perfil.php?action=ver", function(data) {
      try {
        let perfil = JSON.parse(data);

        $("#ver_usuario").text(perfil.usuario);
        $("#ver_rol").text(perfil.rol.charAt(0).toUpperCase() + perfil.rol.slice(1));
        $("#ver_nombres").text(perfil.nombres);
        $("#ver_apellidos").text(perfil.apellidos);
        $("#ver_telefono").text(perfil.telefono);

        $("#nombres").val(perfil.nombres);
        $("#apellidos").val(perfil.apellidos);
        $("#telefono").val(perfil.telefono);
      } catch (e) {
        Swal.fire({
          icon: 'error',
          title: 'Error al cargar datos',
          text: e.message
        });
      }
    });
  }

  cargarPerfil();

  $("#formPerfil").on("submit", function(e) {
    e.preventDefault();
    $.post("../ajax/perfil.php?action=actualizar", $(this).serialize(), function(res) {
      try {
        let data = JSON.parse(res);
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Perfil actualizado',
            text: 'Los datos se han guardado correctamente.'
          }).then(() => {
            let modalEl = document.getElementById('modalEditarPerfil');
            let modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            cargarPerfil();
          });
        } else {
          Swal.fire({
            icon: 'info',
            title: 'Sin cambios',
            text: 'No se realizaron modificaciones en el perfil.'
          });
        }
      } catch (e) {
        Swal.fire({
          icon: 'error',
          title: 'Error al procesar respuesta',
          text: e.message
        });
      }
    });
  });
});
