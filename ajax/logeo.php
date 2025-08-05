<?php
session_start();
require_once "../modelos/logeo.php";

$usuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
$contrasena = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]) : "";

$logeo = new Logeo();
$respuesta = $logeo->verificar($usuario, $contrasena);

if ($respuesta && $respuesta['exito']) {
    $_SESSION["usuario"] = $usuario;
    $_SESSION["rol"] = $respuesta['rol'];
    $_SESSION["id_usuario"] = $respuesta['id']; // <-- AGREGADO

    echo json_encode([
        "success" => true,
        "ruta" => "../vistas/" . $respuesta['rol'] . ".php"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "mensaje" => "Usuario o contraseña incorrectos"
    ]);
}
