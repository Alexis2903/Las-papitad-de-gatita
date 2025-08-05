<?php
require_once "../config/conexion.php";

class Pedido
{
   public static function listar($id_repartidor)
{
    $id_repartidor = intval($id_repartidor);
    $sql = "CALL CALL_SP_LISTAR_PEDIDOS_EN_CAMINO($id_repartidor)";
    return ejecutarConsultaSP($sql);
}


    public static function registrarEntrega($id_pedido, $id_repartidor, $latitud, $longitud, $hora_demora)
    {
        $id_pedido = intval($id_pedido);
        $id_repartidor = intval($id_repartidor);
        $latitud = floatval($latitud);
        $longitud = floatval($longitud);
        $hora_demora_sql = "'$hora_demora'";

        $sql = "CALL CALL_SP_REGISTRAR_ENTREGA($id_pedido, $id_repartidor, $latitud, $longitud, $hora_demora_sql)";
        return ejecutarConsultaSP($sql);
    }
public static function registrarPago($id_pedido, $id_repartidor, $pago_viaje)
{
    $id_pedido = intval($id_pedido);
    $id_repartidor = intval($id_repartidor);
    $pago_viaje = floatval($pago_viaje);

    $sql = "CALL CALL_SP_REGISTRAR_PAGO($id_pedido, $id_repartidor, $pago_viaje)";
    return ejecutarConsultaSP($sql);
}

    public static function registrarDemora($id_pedido, $id_repartidor, $hora_demora)
    {
        $id_pedido = intval($id_pedido);
        $id_repartidor = intval($id_repartidor);
        $hora_demora_sql = "'$hora_demora'";

        $sql = "CALL CALL_SP_REGISTRAR_DEMORA($id_pedido, $id_repartidor, $hora_demora_sql)";
        return ejecutarConsultaSP($sql);
    }
}
?>
