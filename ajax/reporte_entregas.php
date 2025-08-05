<?php
require_once '../modelos/entrega.php';
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Para PDF o AJAX donde recibes filtro
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;

if ($fecha) {
    $res = Entrega::listarDetalladoPorFecha($fecha);
} else {
    $res = Entrega::listarDetallado();
}


// Logo izquierdo
$logoPathLeft = realpath(__DIR__ . '/../vistas/dist/img/comidarapida.png');
// Logo derecho (puede ser el mismo o diferente)
$logoPathRight = realpath(__DIR__ . '/../vistas/dist/img/logo.png');

$logoBase64Left = '';
$logoBase64Right = '';

if (file_exists($logoPathLeft)) {
    $type = pathinfo($logoPathLeft, PATHINFO_EXTENSION);
    $data = file_get_contents($logoPathLeft);
    $logoBase64Left = 'data:image/' . $type . ';base64,' . base64_encode($data);
}

if (file_exists($logoPathRight)) {
    $type = pathinfo($logoPathRight, PATHINFO_EXTENSION);
    $data = file_get_contents($logoPathRight);
    $logoBase64Right = 'data:image/' . $type . ';base64,' . base64_encode($data);
}

$html = '
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Entregas</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        color: #222;
        background: #fff;
    }
    .word-border {
        border: 4px solid #2193b0;
        border-radius: 12px;
        margin: 24px auto;
        max-width: 900px;
        min-height: 96vh;
        box-sizing: border-box;
        padding: 32px 38px;
        box-shadow: 0 2px 16px #2193b030;
        background: #fff;
    }
    .logo-pdf {
        display: block;
        margin: 0 auto 10px auto;
        width: 110px;
        height: auto;
        border-radius: 12px;
        border: 3px solid #2193b0;
        box-shadow: 0 2px 8px #2193b050;
    }
    .titulo-pdf {
        text-align: center;
        font-size: 2.2rem;
        color: #2193b0;
        font-weight: 900;
        margin: 0 0 6px 0;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .subtitulo-pdf {
        text-align: center;
        font-size: 1.15rem;
        color: #dc3545;
        font-weight: 700;
        margin: 10px 0 18px 0;
        text-transform: uppercase;
    }
    .tabla-pdf {
        width: 100%;
        border-collapse: collapse;
        font-size: 1rem;
        background: #fff;
        margin-top: 10px;
    }
    .tabla-pdf thead th {
        background: #fff;
        color: #222;
        font-weight: 800;
        font-size: 1.08rem;
        border: 2px solid #222;
        padding: 12px 10px;
        text-align: left;
    }
    .tabla-pdf tbody td {
        border: 1px solid #222;
        padding: 10px 8px;
        color: #222;
        font-weight: 500;
        background: #fff;
    }
    .tabla-pdf tbody tr:nth-child(even) td {
        background: #fff;
    }
</style>
</head>
<body>
    <div class="word-border">
        <div class="titulo-pdf">Reporte de entregas del Restaurante De Comida Rapida Las Papitas De Gatita</div><br>
        <div style="text-align:center;">
            ' . ($logoBase64Right ? '<img src="' . $logoBase64Right . '" class="logo-pdf">' : '') . '
        </div><br>
        <div style="text-align:center;font-size:1.08rem;color:#2193b0;font-weight:700;margin-bottom:10px;margin-top:2px;">ADMINISTRADOR DEL NEGOCIO: FERNANDO CAPA</div> <br>
        <table class="tabla-pdf"> 
            <thead>
                <tr>
                    <th colspan="5" style="text-align:center;font-size:1.1rem;color:#dc3545;font-weight:700;position:relative;">
                        <span style="vertical-align:middle;">Reporte de los Pedidos Entregados</span>
                        ' . ($logoBase64Left ? '<img src="' . $logoBase64Left . '" style="height:24px;width:auto;vertical-align:middle;margin-left:8px;border-radius:6px;border:1.5px solid #dc3545;">' : '') . '
                    </th>
                </tr>
                <tr>
                    <th style="text-transform:uppercase;font-weight:900;">Cliente</th>
                    <th style="text-transform:uppercase;font-weight:900;">Productos</th>
                    <th style="text-transform:uppercase;font-weight:900;">Repartidor</th>
                    <th style="text-transform:uppercase;font-weight:900;">Hora<br>Salida</th>
                    <th style="text-transform:uppercase;font-weight:900;">Hora<br>Entregado</th>
                </tr>
            </thead>
            <tbody>';

while ($row = $res->fetch_assoc()) {
    if ($row['hora_entrega']) {
        $cliente = htmlspecialchars($row['nombre_cliente'] . ' ' . $row['apellido_cliente']);
        $repartidor = $row['nombre_repartidor'] ? htmlspecialchars($row['nombre_repartidor'] . ' ' . $row['apellido_repartidor']) : '---';
        $productos = htmlspecialchars($row['productos']);
        $hora_salida = $row['hora_salida'] ?? '---';
        $hora_entrega = $row['hora_entrega'] ?? '---';

        $html .= "<tr>
                    <td style='font-weight:400;text-transform:none;'>{$cliente}</td>
                    <td style='font-weight:400;text-transform:none;'>{$productos}</td>
                    <td style='font-weight:400;text-transform:none;'>{$repartidor}</td>
                    <td style='font-weight:400;text-transform:none;'>{$hora_salida}</td>
                    <td style='font-weight:400;text-transform:none;'>{$hora_entrega}</td>
                  </tr>";
    }
}

$html .= '
            </tbody>
        </table>
    </div>
</body>
</html>
';

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('reporte_entregas.pdf', ['Attachment' => false]);
