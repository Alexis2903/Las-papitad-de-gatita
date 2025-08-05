<?php
require_once "../config/conexion.php";

class Usuario {
    public function insertarCliente($nombres, $apellidos, $telefono, $usuario, $contrasena) {
        global $conexion;

        $sql = "CALL sp_insertar_usuario_cliente(?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssss", $nombres, $apellidos, $telefono, $usuario, $contrasena);
        return $stmt->execute();
    }

     public function existeUsuario(string $usuario): bool {
        global $conexion;

        $sql  = "SELECT COUNT(*) AS total FROM usuarios WHERE usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return isset($res['total']) && $res['total'] > 0;
    }
}
?>
