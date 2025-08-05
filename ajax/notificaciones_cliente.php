<?php 
require_once "../config/conexion.php";

if (!isset($_GET['id_cliente'])) {
    echo json_encode(['status' => 'error', 'message' => 'Falta id_cliente']);
    exit;
}

$id_cliente = intval($_GET['id_cliente']);

$sql = "
SELECT 
    e.hora_salida,
    r.nombres AS nombre_repartidor,
    r.apellidos AS apellido_repartidor
FROM entregas e
INNER JOIN pedidos p ON e.id_pedido = p.id_pedido
INNER JOIN usuarios r ON e.id_repartidor = r.id_usuario
WHERE p.id_cliente = $id_cliente
  AND e.estado_entrega = 'En camino'
ORDER BY e.hora_salida DESC
LIMIT 10
";

$result = mysqli_query($conexion, $sql);

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Error en la consulta: ' . mysqli_error($conexion)]);
    exit;
}

$notificaciones = [];

while ($row = mysqli_fetch_assoc($result)) {
    $notificaciones[] = [
        'hora_salida' => $row['hora_salida'],
        'nombre_repartidor' => $row['nombre_repartidor'],
        'apellido_repartidor' => $row['apellido_repartidor']
    ];
}

echo json_encode([
    'status' => 'success',
    'notificaciones' => $notificaciones
]);
