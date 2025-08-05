<?php
require_once "../config/conexion.php";

class Rol {
    public function crudRol($accion, $id, $nombres, $apellidos, $telefono, $usuario, $contrasena, $rol) {
        global $conexion;

        $sql = "CALL sp_crud_empleados(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param(
            "sissssss",
            $accion,
            $id,
            $nombres,
            $apellidos,
            $telefono,
            $usuario,
            $contrasena,
            $rol
        );

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
