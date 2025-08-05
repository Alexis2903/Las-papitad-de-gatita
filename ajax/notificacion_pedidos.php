<?php
require_once '../config/conexion.php';

$response = ['status' => 'success', 'nuevos' => 0, 'pedidos' => []];

$sqlPedidos = "
SELECT 
    p.id_pedido,
    CONCAT(u.nombres, ' ', u.apellidos) AS nombre_cliente,
    p.tiempo_estimado_preparacion,
    p.fecha_pedido,
    GROUP_CONCAT(DISTINCT pr.nombre_evento SEPARATOR ', ') AS eventos
FROM pedidos p
JOIN usuarios u ON p.id_cliente = u.id_usuario
JOIN detalle_pedido dp ON p.id_pedido = dp.id_pedido
JOIN productos pr ON dp.id_producto = pr.id_producto
WHERE p.estado = 'Preparando'
GROUP BY p.id_pedido, u.nombres, u.apellidos, p.tiempo_estimado_preparacion, p.fecha_pedido
ORDER BY p.fecha_pedido DESC
LIMIT 100";

$resultadoPedidos = mysqli_query($conexion, $sqlPedidos);

if ($resultadoPedidos && mysqli_num_rows($resultadoPedidos) > 0) {
    while ($pedido = mysqli_fetch_assoc($resultadoPedidos)) {
        $idPedido = $pedido['id_pedido'];

        // Ahora consultamos los productos detallados para este pedido
        $sqlProductos = "
            SELECT 
                pr.nombre,
                dp.cantidad,
                dp.precio_unitario,
                (dp.cantidad * dp.precio_unitario) AS total_producto
            FROM detalle_pedido dp
            JOIN productos pr ON dp.id_producto = pr.id_producto
            WHERE dp.id_pedido = $idPedido";

        $resultadoProductos = mysqli_query($conexion, $sqlProductos);

        $productos = [];
        if ($resultadoProductos && mysqli_num_rows($resultadoProductos) > 0) {
            while ($producto = mysqli_fetch_assoc($resultadoProductos)) {
                $productos[] = [
                    'nombre' => $producto['nombre'],
                    'cantidad' => (int)$producto['cantidad'],
                    'precio_unitario' => (float)$producto['precio_unitario'],
                    'total_producto' => (float)$producto['total_producto']
                ];
            }
        }

        $response['pedidos'][] = [
            'id_pedido' => $pedido['id_pedido'],
            'nombre_cliente' => $pedido['nombre_cliente'],
            'tiempo_estimado_preparacion' => $pedido['tiempo_estimado_preparacion'],
            'eventos' => $pedido['eventos'],
            'productos' => $productos,
            'hora' => date('H:i', strtotime($pedido['fecha_pedido']))
        ];
    }
    $response['nuevos'] = count($response['pedidos']);
} else {
    $response['status'] = 'empty';
}

echo json_encode($response);
