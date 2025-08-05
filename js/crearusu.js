// campos a limpiar/mostrar error
const campos = ['nombres','apellidos','telefono','usuario','contrasena'];

function limpiarErrores() {
  campos.forEach(c => {
    const div = document.getElementById(`error-${c}`);
    if (div) div.textContent = '';
  });
  const msg = document.getElementById('mensaje');
  msg.classList.add('d-none');
}

function mostrarErrores(errores) {
  for (const campo in errores) {
    const div = document.getElementById(`error-${campo}`);
    if (div) div.textContent = errores[campo].join(', ');
  }
}

// Listener submit
document.getElementById("formRegistroCliente")
.addEventListener("submit", function(e) {
  e.preventDefault();
  limpiarErrores();

  const formData = new FormData(this);

  fetch("../ajax/crearusu.php", {
    method: "POST",
    body: formData
  })
  .then(r => r.json())
  .then(data => {
    const mensaje = document.getElementById("mensaje");
    mensaje.classList.remove("d-none", "alert-success", "alert-danger");

    if (data.success) {
      mensaje.classList.add("alert-success");
      mensaje.textContent = data.mensaje || "¡Registro exitoso! Redirigiendo...";
      this.reset();
      setTimeout(function() {
        window.location.href = "logeo.php";
      }, 1800);
    } else if (data.errors) {
      // errores de campo
      mostrarErrores(data.errors);
      mensaje.classList.add("alert-danger");
      mensaje.textContent = "Corrige los errores marcados.";
    } else {
      mensaje.classList.add("alert-danger");
      mensaje.textContent = data.mensaje || "Error desconocido";
    }
  })
  .catch(error => {
    const mensaje = document.getElementById("mensaje");
    mensaje.classList.remove("d-none", "alert-success");
    mensaje.classList.add("alert-danger");
    mensaje.textContent = "Error en la petición: " + error;
  });
});
