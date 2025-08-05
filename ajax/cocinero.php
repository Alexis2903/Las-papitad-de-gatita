<?php
require_once "../modelos/cocinero.php";

$action = $_GET['action'] ?? '';

if ($action === 'listar') {
    $result = PedidoCocinero::listar();
    $repartidores = PedidoCocinero::obtenerRepartidores();
    $pedidos = [];

    while ($row = $result->fetch_assoc()) {
        $pedidos[] = [
            "id_pedido" => (int)$row["id_pedido"],
            "nombre_cliente" => $row["nombres"] . " " . $row["apellidos"],
            "fecha_pedido" => $row["fecha_pedido"],
            "tiempo_estimado" => (int)$row["tiempo_estimado_preparacion"],
            "total" => (float)$row["total"],
            "estado" => $row["estado"],
            "id_repartidor" => $row["id_repartidor"]
        ];
    }

    echo json_encode([
        "status" => "success",
        "pedidos" => $pedidos,
        "repartidores" => $repartidores
    ]);
    exit;
}

if ($action === 'listarPorEvento' && isset($_GET['evento'])) {
    $evento = $_GET['evento'];
    $result = PedidoCocinero::listarPorEvento($evento);
    $repartidores = PedidoCocinero::obtenerRepartidores();
    $pedidos = [];

    while ($row = $result->fetch_assoc()) {
        $pedidos[] = [
            "id_pedido" => (int)$row["id_pedido"],
            "nombre_cliente" => $row["nombres"] . " " . $row["apellidos"],
            "fecha_pedido" => $row["fecha_pedido"],
            "tiempo_estimado" => (int)$row["tiempo_estimado_preparacion"],
            "total" => (float)$row["total"],
            "estado" => $row["estado"],
            "id_repartidor" => $row["id_repartidor"]
        ];
    }

    echo json_encode([
        "status" => "success",
        "pedidos" => $pedidos,
        "repartidores" => $repartidores
    ]);
    exit;
}

if ($action === 'eventos') {
    $eventos = PedidoCocinero::obtenerEventos();
    echo json_encode([
        "status" => "success",
        "eventos" => $eventos
    ]);
    exit;
}

if ($action === 'procesarEntrega' && isset($_POST['id_pedido'], $_POST['estado'], $_POST['id_repartidor'])) {
    $id_pedido = intval($_POST['id_pedido']);
    $estado = $_POST['estado'];
    $id_repartidor = intval($_POST['id_repartidor']);

    $sql = "UPDATE pedidos SET estado = '$estado', id_repartidor = $id_repartidor WHERE id_pedido = $id_pedido";
    $resultado = ejecutarConsulta($sql);

    if ($resultado && $estado === 'En camino') {
        $resEntrega = PedidoCocinero::actualizarEntrega($id_pedido, $id_repartidor, $estado);
        if (!$resEntrega) {
            echo json_encode(["status" => "error", "message" => "Error al actualizar entrega"]);
            exit;
        }
    }

    if ($resultado) {
        echo json_encode(["status" => "success", "message" => "Actualización exitosa"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar"]);
    }
    exit;
}

if ($_GET["action"] == "notificacionesCliente") {
    $id_cliente = $_GET["id_cliente"];
    $res = PedidoCocinero::listarNotificacionesCliente($id_cliente);
    $notificaciones = [];

    while ($row = $res->fetch_assoc()) {
       $notificaciones[] = [
    "id_pedido" => $row["id_pedido"],
    "fecha_pedido" => $row["fecha_pedido"],
    "nombre_repartidor" => $row["nombre_repartidor"],
    "apellido_repartidor" => $row["apellido_repartidor"],
    "hora_salida" => $row["hora_salida"],
    "hora_demora" => $row["hora_demora"],
    "pago_viaje" => $row["pago_viaje"],
    "estado_entrega" => $row["estado_entrega"],
    "estado" => $row["estado"]
];

    }

    echo json_encode([
        "status" => "success",
        "notificaciones" => $notificaciones
    ]);
    exit;
}



if ($action === 'marcarNotificacion' && isset($_POST['id_pedido'])) {
    $id_pedido = intval($_POST['id_pedido']);
    $res = PedidoCocinero::marcarNotificacionVista($id_pedido);
    if ($res) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    exit;
}
if ($action === 'eventoPorPedido' && isset($_GET['id_pedido'])) {
    $id_pedido = intval($_GET['id_pedido']);
    $evento = PedidoCocinero::obtenerEventoPorPedido($id_pedido); // Implementa este método en tu modelo
    if ($evento) {
        echo json_encode(["status" => "success", "evento" => $evento]);
    } else {
        echo json_encode(["status" => "error", "message" => "Evento no encontrado para pedido"]);
    }
    exit;
}

?>
