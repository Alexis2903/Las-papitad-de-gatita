<?php
require_once "../config/conexion.php"; 

class Logeo {

    public function verificar($usuario, $contrasenaIngresada) {
        global $conexion;

        // Llamamos al SP con salida de id, contraseña y rol
        $stmt = $conexion->prepare("CALL sp_iniciar_sesion(?, @id_usuario, @hash_db, @rol_db)");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->close();

        // Traemos los resultados de salida
        $resultado = $conexion->query("SELECT @id_usuario AS id_usuario, @hash_db AS hash_db, @rol_db AS rol_db");
        $datos = $resultado->fetch_assoc();

        if ($datos && $datos['hash_db'] !== null) {
            $hashGuardado = $datos['hash_db'];
            $rol = $datos['rol_db'];
            $id = $datos['id_usuario'];

            // Verifica la contraseña con password_verify
            if (password_verify($contrasenaIngresada, $hashGuardado)) {
                return [
                    'rol' => $rol,
                    'id' => $id,
                    'exito' => true
                ];
            }
        }

        return ['rol' => null, 'id' => null, 'exito' => false];
    }
}
