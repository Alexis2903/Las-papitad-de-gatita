<?php
session_start();
require_once "../modelos/pedido.php";

$pedido = new Pedido();
$op = $_GET['op'] ?? '';

if ($op === 'listar') {
    $tipo = $_GET['tipo'] ?? 'todos';
    $rs = $pedido->listarProductosPorTipo($tipo);
    $datos = [];

    while ($row = $rs->fetch_assoc()) {
        $datos[] = $row;
    }

    echo json_encode($datos);
    exit;
}

if ($op === 'listarTipos') {
    $rs = $pedido->listarProductosPorTipo('tipos');
    $datos = [];

    while ($row = $rs->fetch_assoc()) {
        if (!empty($row['nombre_evento'])) {
            // Ahora guardamos todo el row para mostrar info completa
            $datos[] = $row;
        }
    }

    echo json_encode($datos);
    exit;
}

if ($op === 'guardarPedido') {
    if (!isset($_SESSION['id_usuario'])) {
        echo json_encode(['status' => 'error', 'msg' => 'No autenticado']);
        exit;
    }

    $id_cliente = $_SESSION['id_usuario'];
    $latitud = $_POST['latitud'] ?? '0';
    $longitud = $_POST['longitud'] ?? '0';
    $ubicacion_extra = $_POST['ubicacion_extra'] ?? '';
    $carrito = json_decode($_POST['carrito'] ?? '[]', true);
    $tipo_pedido = $_POST['tipo_pedido'] ?? 'normal';
    $hora_entrega = $_POST['hora_entrega'] ?? null;

    if (empty($carrito)) {
        echo json_encode(['status' => 'error', 'msg' => 'Carrito vacío']);
        exit;
    }

    foreach ($carrito as &$item) {
        $producto = $pedido->obtenerDatosProducto($item['id_producto']);
        if ($producto) {
            $item['precio'] = floatval($producto['precio']);
            $item['tiempo_preparacion'] = intval($producto['tiempo_preparacion']);
            $item['fecha_evento'] = $producto['fecha_evento'];
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Producto no encontrado: ' . $item['id_producto']]);
            exit;
        }
    }
    unset($item);

    $id_pedido = $pedido->registrarPedido(
        $id_cliente,
        $latitud,
        $longitud,
        $carrito,         
        $tipo_pedido,
        $hora_entrega,
        $ubicacion_extra  
    );

    if ($id_pedido) {
        echo json_encode(['status' => 'success', 'msg' => 'Pedido registrado correctamente', 'id_pedido' => $id_pedido]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Error al registrar pedido']);
    }
    exit;
}
?>
