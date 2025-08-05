<?php
require_once "../modelos/empleados.php";
require_once __DIR__ . '/../vendor/autoload.php';
use Valitron\Validator;

Validator::lang('es');
ini_set('display_errors', 0);
error_reporting(0);
ob_start();

$accion    = $_POST['accion']     ?? '';
$id        = $_POST['id_usuario'] ?? 0;
$nombres   = $_POST['nombres']    ?? '';
$apellidos = $_POST['apellidos']  ?? '';
$telefono  = $_POST['telefono']   ?? '';
$usuario   = $_POST['usuario']    ?? '';
$contrasena= $_POST['contrasena'] ?? '';
$rol       = $_POST['rol']        ?? '';

$rolObj = new Rol();

// LISTAR
if ($accion === 'LISTAR') {
    $usuarios = $rolObj->crudRol($accion, $id, $nombres, $apellidos, $telefono, $usuario, $contrasena, $rol);
    ob_end_clean();
    echo json_encode(['data' => $usuarios]);  // Devuelve JSON con datos para DataTables
    exit;
}

// ELIMINAR
if ($accion === 'ELIMINAR') {
    $res = $rolObj->crudRol($accion, $id, '', '', '', '', '', '');
    ob_end_clean();
    echo json_encode(['success' => $res]);
    exit;
}

// INSERTAR / MODIFICAR
if ($accion === 'INSERTAR' || $accion === 'MODIFICAR') {
    $hash = null;
    if (!empty($contrasena)) {
      $hash = password_hash($contrasena, PASSWORD_DEFAULT);
    }

    $datos = compact('nombres','apellidos','telefono','usuario','contrasena','rol');
    $v = new Validator($datos);

    $v->rule('required', ['nombres','apellidos','telefono','usuario','rol']);
    $v->rule('lengthMin', ['nombres','apellidos'], 2);
    $v->rule('regex', ['nombres','apellidos'], '/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/')->message('El campo {field} solo puede contener letras y espacios');
    $v->rule('regex', 'telefono', '/^[0-9]{10}$/')->message('El teléfono debe tener exactamente 10 dígitos numéricos');
    $v->rule('regex', 'usuario', '/^[A-Za-z0-9]{3,15}$/')->message('El usuario debe tener entre 3 y 15 caracteres alfanuméricos');
    if ($contrasena !== '') {
      $v->rule('lengthMin', 'contrasena', 8)->message('La contraseña debe tener al menos 8 caracteres');
      $v->rule('regex', 'contrasena', '/^(?=.*[A-Za-z])(?=.*\d).+$/')->message('La contraseña debe contener letras y números');
    }
    $v->rule('in', 'rol', ['cocinero','repartidor']);

    if (!$v->validate()) {
        ob_end_clean();
        echo json_encode(['success'=>false,'errors'=>$v->errors()]);
        exit;
    }

    $res = $rolObj->crudRol($accion, $id, $nombres, $apellidos, $telefono, $usuario, $hash, $rol);
    ob_end_clean();
    echo json_encode(['success'=>$res]);
    exit;
}

ob_end_clean();
echo json_encode(['success'=>false,'errors'=>['accion'=>['Acción no válida']]]);
exit;
?>
