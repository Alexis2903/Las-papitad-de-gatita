<?php
require_once "../config/conexion.php";

class PedidoCocinero
{
    public static function listar()
    {
        $sql = "CALL CALL_SP_LISTAR_PEDIDOS_PREPARANDO()";
        return ejecutarConsultaSP($sql);
    }

    public static function listarPorEvento($evento)
    {
        $evento = limpiarCadena($evento);
        $sql = "CALL CALL_SP_LISTAR_PEDIDOS_POR_EVENTO('$evento')";
        return ejecutarConsultaSP($sql);
    }

    public static function obtenerEventos()
    {
        $sql = "CALL CALL_SP_OBTENER_EVENTOS()";
        $res = ejecutarConsultaSP($sql);
        $eventos = [];
        while ($row = $res->fetch_assoc()) {
            $eventos[] = $row['nombre_evento'];
        }
        return $eventos;
    }

    public static function obtenerRepartidores()
    {
        $sql = "CALL CALL_SP_OBTENER_REPARTIDORES()";
        $res = ejecutarConsultaSP($sql);
        $repartidores = [];
        while ($row = $res->fetch_assoc()) {
            $repartidores[] = $row;
        }
        return $repartidores;
    }

    public static function asignarRepartidor($id_pedido, $id_repartidor)
    {
        $id_pedido = intval($id_pedido);
        $id_repartidor = intval($id_repartidor);
        $sql = "CALL CALL_SP_ASIGNAR_REPARTIDOR($id_pedido, $id_repartidor)";
        return ejecutarConsultaSP($sql);
    }

    public static function actualizarEstado($id_pedido, $estado)
    {
        $id_pedido = intval($id_pedido);
        $estado = limpiarCadena($estado);
        $sql = "CALL CALL_SP_ACTUALIZAR_ESTADO($id_pedido, '$estado')";
        return ejecutarConsultaSP($sql);
    }

    public static function actualizarEntrega($id_pedido, $id_repartidor, $estado)
    {
        $id_pedido = intval($id_pedido);
        $id_repartidor = intval($id_repartidor);
        $estado = limpiarCadena($estado);
        $sql = "CALL CALL_SP_ACTUALIZAR_ENTREGA($id_pedido, $id_repartidor, '$estado')";
        return ejecutarConsultaSP($sql);
    }
    public static function listarNotificacionesCliente($id_cliente) {
    $id_cliente = intval($id_cliente);
    $sql = "CALL CALL_SP_LISTAR_NOTIFICACIONES_CLIENTE($id_cliente)";
    return ejecutarConsultaSP($sql);
}

public static function marcarNotificacionVista($id_pedido) {
    $id_pedido = intval($id_pedido);
    $sql = "CALL CALL_SP_MARCAR_NOTIFICACION_VISTA($id_pedido)";
    return ejecutarConsultaSP($sql);
}

}
?>
