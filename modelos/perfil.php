<?php
require_once "../config/conexion.php";

class Perfil
{
    public function verPerfil($id_usuario)
    {
        // El rol se envía, pero no se usa para nada en la acción 'ver'
        $sql = "CALL spGestionUsuario($id_usuario, '', '', '', '', '', 'cliente', 'ver')";
        return ejecutarConsultaSP($sql);
    }

    public function actualizarPerfil($id_usuario, $nombres, $apellidos, $telefono)
    {
        // En la actualización no se usan usuario, contraseña ni rol, pero hay que enviarlos igual para el SP
        $sql = "CALL spGestionUsuario(
            $id_usuario,
            '$nombres',
            '$apellidos',
            '$telefono',
            '',      -- p_usuario no se usa para actualizar
            '',      -- p_contrasena no se usa para actualizar
            'cliente',  -- p_rol no se usa para actualizar
            'actualizar')";
        return ejecutarConsultaSP($sql);
    }
}
?>
