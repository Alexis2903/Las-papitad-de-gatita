<?php
require_once "../config/conexion.php";

class Pedido {
    public function listarProductosPorTipo($tipo = 'todos') {
        $tipo = limpiarCadena(strtolower($tipo));
        $sql = "CALL CALL_SP_LISTAR_PRODUCTOS('$tipo')";
        return ejecutarConsultaSP($sql);
    }

    public function obtenerDatosProducto($id_producto) {
        $id = intval($id_producto);
        $sql = "CALL CALL_SP_GET_PRODUCTO($id)";
        $res = ejecutarConsultaSP($sql);
        return $res ? $res->fetch_assoc() : null;
    }

    public function registrarPedido($id_cliente, $latitud, $longitud, $carrito, $tipo_pedido = 'normal', $hora_entrega = null, $ubicacion_extra = '') {
        $total = 0;
        $tiempo_estimado = 0;

        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
            $tiempo_estimado += $item['tiempo_preparacion'] * $item['cantidad'];
        }

        $fecha_evento = ($tipo_pedido !== 'normal') ? ($carrito[0]['fecha_evento'] ?? null) : null;
        $lat = floatval($latitud);
        $lon = floatval($longitud);
        $total = floatval($total);
        $tiempo = intval($tiempo_estimado);

        $fecha_sql = $fecha_evento ? "'$fecha_evento'" : "NULL";
        $hora_sql = $hora_entrega ? "'$hora_entrega'" : "NULL";

        $sql = "CALL CALL_SP_REGISTRAR_PEDIDO(
            $id_cliente,
            $lat,
            $lon,
            $tiempo,
            $total,
            '$tipo_pedido',
            $fecha_sql,
            $hora_sql,
            '$ubicacion_extra'
        )";

        $res = ejecutarConsultaSP($sql);
        if (!$res) return false;

        $row = $res->fetch_assoc();
        if (!$row || empty($row['id_pedido'])) return false;

        $id_pedido = $row['id_pedido'];

        foreach ($carrito as $item) {
            $id_prod = intval($item['id_producto']);
            $cant = intval($item['cantidad']);
            $precio = floatval($item['precio']);
            $sql_detalle = "CALL CALL_SP_INSERTAR_DETALLE_PEDIDO($id_pedido, $id_prod, $cant, $precio)";
            ejecutarConsultaSP($sql_detalle);
        }

        return $id_pedido;
    }
}
?>
