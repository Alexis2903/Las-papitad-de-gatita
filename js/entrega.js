$(document).ready(function(){
    // Carga inicial: todos los datos
    $('#contenedorTabla').load('../ajax/entrega.php?op=listar', function(){
        $('#tablaEntregas').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
        });
    });

    // Limpia mensaje de error
    function limpiarErrorFecha() {
        $('#error-fechaFiltro').text('').hide();
    }

    // Al filtrar por fecha
    $('#btnFiltrar').on('click', function() {
        const fecha = $('#fechaFiltro').val();
        limpiarErrorFecha();

        if (!fecha) {
            // En vez de alert, muestra el mensaje debajo del input
            $('#error-fechaFiltro').text('Por favor selecciona una fecha.').show();
            return;
        }

        $('#contenedorTabla').load(`../ajax/entrega.php?op=listar&fecha=${fecha}`, function(){
            $('#tablaEntregas').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });

        $('#btnPdf').attr('href', `../ajax/reporte_entregas.php?fecha=${fecha}`);
    });

    // Limpia error si el usuario cambia la fecha
    $('#fechaFiltro').on('input', limpiarErrorFecha);
});
