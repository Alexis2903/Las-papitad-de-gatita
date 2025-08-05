<?php
require_once "../modelos/entrega.php";
require_once __DIR__ . '/../vendor/autoload.php';

use Valitron\Validator;

if (isset($_GET['op']) && $_GET['op'] == "listar") {
    $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;

    // Validar solo si la fecha está vacía (pero existe)
    if (isset($_GET['fecha']) && $fecha === '') {
        $v = new Validator(['fecha' => $fecha]);
        $v->rule('required', 'fecha')->message('Por favor selecciona una fecha.');

        if (!$v->validate()) {
            echo json_encode(['error' => $v->errors()]);
            exit;
        }
    }

    if ($fecha) {
        $res = Entrega::listarDetalladoPorFecha($fecha);
    } else {
        $res = Entrega::listarDetallado();
    }

    echo '<table id="tablaEntregas" class="table table-bordered table-striped table-hover text-center">';
    echo '<thead class="bg-primary text-white">';
    echo '<tr>';
    echo '<th>Cliente</th><th>Productos</th><th>Repartidor</th><th>Hora Salida</th><th>Hora Entregado</th>';
    echo '</tr>';
    echo '</thead><tbody>';

    while ($row = $res->fetch_assoc()) {
        $cliente = htmlspecialchars($row['nombre_cliente'] . ' ' . $row['apellido_cliente']);
        $repartidor = $row['nombre_repartidor'] ? htmlspecialchars($row['nombre_repartidor'] . ' ' . $row['apellido_repartidor']) : '---';
        $productos = htmlspecialchars($row['productos']);
        $hora_salida = $row['hora_salida'] ?? '---';
        $hora_entrega = $row['hora_entrega'] ?? '---';

        echo "<tr>
                <td>{$cliente}</td>
                <td>{$productos}</td>
                <td>{$repartidor}</td>
                <td>{$hora_salida}</td>
                <td>{$hora_entrega}</td>
              </tr>";
    }

    echo '</tbody></table>';
}
