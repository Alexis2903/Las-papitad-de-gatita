<?php
require_once "../config/conexion.php";

class Entrega
{
    public static function listarDetallado()
    {
        $sql = "CALL sp_listar_entregas_detallado()";
        return ejecutarConsultaSP($sql);
    }

    public static function listarDetalladoPorFecha($fecha = null)
    {
        $fechaParam = $fecha ? "'$fecha'" : 'NULL';
        $sql = "CALL sp_listar_entregas_detallado_por_fecha($fechaParam)";
        return ejecutarConsultaSP($sql);
    }
}

?>
