<?php
require_once "../modelos/crearusu.php";
require_once __DIR__ . '/../vendor/autoload.php';
use Valitron\Validator;

Validator::lang('es');
ini_set('display_errors', 1);
error_reporting(E_ALL);
ob_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_end_clean();
    echo json_encode(['success'=>false,'errors'=>['general'=>['Método no permitido']]]);
    exit;
}

$nombres    = $_POST['nombres']    ?? '';
$apellidos  = $_POST['apellidos']  ?? '';
$telefono   = $_POST['telefono']   ?? '';
$usuario    = $_POST['usuario']    ?? '';
$contrasena = $_POST['contrasena'] ?? '';

$datos = compact('nombres','apellidos','telefono','usuario','contrasena');
$v = new Validator($datos);
$v->rule('required',      ['nombres','apellidos','telefono','usuario','contrasena']);
$v->rule('lengthMin',     ['nombres','apellidos'], 2);
$v->rule('regex', ['nombres','apellidos'], '/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/')
  ->message('El campo {field} solo puede contener letras y espacios');
$v->rule('regex', 'telefono', '/^[0-9]{10}$/')
  ->message('El teléfono debe tener exactamente 10 dígitos numéricos');
$v->rule('regex', 'usuario', '/^[A-Za-z0-9]{3,15}$/')
  ->message('El usuario debe tener 3–15 caracteres, solo letras y números');
$v->rule('lengthMin', 'contrasena', 8)
  ->message('La contraseña debe tener al menos 8 caracteres');
$v->rule('regex', 'contrasena', '/^(?=.*[A-Za-z])(?=.*\d).+$/')
  ->message('La contraseña debe contener letras y números');

if (!$v->validate()) {
    ob_end_clean();
    echo json_encode(['success'=>false,'errors'=>$v->errors()]);
    exit;
}

// Validación extra: usuario único
$usuarioObj = new Usuario();
if ($usuarioObj->existeUsuario($usuario)) {
    ob_end_clean();
    echo json_encode([
      'success' => false,
      'errors' => ['usuario' => ['El nombre de usuario ya está en uso, elige otro.']]
    ]);
    exit;
}

// Todo ok: insertar
$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
$res = $usuarioObj->insertarCliente($nombres, $apellidos, $telefono, $usuario, $contrasenaHash);

ob_end_clean();
if ($res) {
    echo json_encode(['success'=>true,'mensaje'=>'Usuario creado correctamente']);
} else {
    echo json_encode(['success'=>false,'errors'=>['general'=>['Error al crear el usuario']]]);
}
exit;
