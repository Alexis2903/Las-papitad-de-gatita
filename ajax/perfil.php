<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../modelos/perfil.php";
 

$perfil = new Perfil();

$id_usuario = isset($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : 0;

if ($id_usuario <= 0) {
    echo json_encode(["error" => "ID de sesión inválido"]);
    exit;
}

switch ($_GET["action"]) {
    case 'ver':
        $rspta = $perfil->verPerfil($id_usuario);
        $datos = $rspta->fetch_assoc();
        echo json_encode($datos);
        break;

    case 'actualizar':
        $nombres = $_POST["nombres"];
        $apellidos = $_POST["apellidos"];
        $telefono = $_POST["telefono"];

        $rspta = $perfil->actualizarPerfil($id_usuario, $nombres, $apellidos, $telefono);
        $res = $rspta->fetch_assoc();
        echo json_encode(["success" => $res["filas_afectadas"] > 0]);
        break;

    default:
        echo json_encode(["error" => "Acción no válida"]);
}
?>
