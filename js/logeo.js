document.getElementById("formLogin").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("../ajax/logeo.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.ruta;
        } else {
            const mensajeError = document.getElementById("mensajeError");
            mensajeError.classList.remove("d-none");
            mensajeError.textContent = data.mensaje;
        }
    })
    .catch(error => {
        console.error("Error:", error);
        const mensajeError = document.getElementById("mensajeError");
        mensajeError.classList.remove("d-none");
        mensajeError.textContent = "Error del servidor. Intenta nuevamente.";
    });
});
