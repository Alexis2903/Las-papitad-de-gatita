<?php
require_once "../modelos/repartidor.php";

session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["status" => "error", "message" => "No autorizado"]);
    exit;
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id_repartidor = $_SESSION['id_usuario'];

    if ($action == "listar") {
    $result = Pedido::listar($id_repartidor);
    $pedidos = [];

    while ($row = $result->fetch_assoc()) {
        $nombreCompleto = $row['nombres'] . ' ' . $row['apellidos'];
        $pedidos[] = [
            'id_pedido' => (int)$row['id_pedido'],
            'nombre_cliente' => $nombreCompleto,
            'telefono_cliente' => $row['telefono'],
            'total' => (float)$row['total'],
            'hora_demora' => $row['hora_demora'] ?? '00:00:00',
            'pago_viaje' => $row['pago_viaje'] !== null ? number_format($row['pago_viaje'], 2) : '0.00',
            'latitud_entrega' => (float)$row['latitud_entrega'],
            'longitud_entrega' => (float)$row['longitud_entrega'],
        ];
    }

    echo json_encode([
        "status" => "success",
        "data" => $pedidos
    ]);
}


    if ($action == "entregar" && isset($_POST['id_pedido'], $_POST['latitud'], $_POST['longitud'])) {
        $id_pedido = intval($_POST['id_pedido']);
        $lat = floatval($_POST['latitud']);
        $lng = floatval($_POST['longitud']);
        // Aquí se recupera la hora_demora guardada previamente o se pone 00:00:00 por defecto
        // Para simplificar, mandamos '00:00:00' (puedes modificar para recuperar la real)
        $horaDemora = '00:00:00';

        $res = Pedido::registrarEntrega($id_pedido, $id_repartidor, $lat, $lng, $horaDemora);

        if ($res) {
            echo json_encode(["status" => "success", "message" => "Entrega registrada correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al registrar entrega"]);
        }
    }

    if ($action == "registrar_demora" && isset($_POST['id_pedido'], $_POST['hora_demora'])) {
        $id_pedido = intval($_POST['id_pedido']);
        $horaDemora = $_POST['hora_demora'];

        $res = Pedido::registrarDemora($id_pedido, $id_repartidor, $horaDemora);

        if ($res) {
            echo json_encode(["status" => "success", "message" => "Demora registrada correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al registrar demora"]);
        }
    }
    if ($action == "registrar_pago" && isset($_POST['id_pedido'], $_POST['pago_viaje'])) {
    $id_pedido = intval($_POST['id_pedido']);
    $pago_viaje = floatval($_POST['pago_viaje']);

    $res = Pedido::registrarPago($id_pedido, $id_repartidor, $pago_viaje);

    if ($res) {
        echo json_encode(["status" => "success", "message" => "Pago registrado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar pago"]);
    }
}

}
?>
