<?php
require_once "../config/conexion.php";

class Clientes {
    public function crudCliente($accion, $id, $nombres, $apellidos, $telefono, $usuario, $rol) {
        global $conexion;

        $sql = "CALL sp_crud_clientes(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("sisssss", $accion, $id, $nombres, $apellidos, $telefono, $usuario, $rol);

        if ($stmt->execute()) {
            if ($accion == 'LISTAR') {
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            return true;
        }
        return false;
    }
}
