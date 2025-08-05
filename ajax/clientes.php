<?php

require_once "../modelos/clientes.php";
require_once __DIR__ . '/../vendor/autoload.php';
use Valitron\Validator;

Validator::lang('es');
ini_set('display_errors', 1);
error_reporting(E_ALL);
ob_start();

$accion    = $_POST['accion']     ?? '';
$id        = $_POST['id_usuario'] ?? 0;
$nombres   = $_POST['nombres']    ?? '';
$apellidos = $_POST['apellidos']  ?? '';
$telefono  = $_POST['telefono']   ?? '';
$usuario   = $_POST['usuario']    ?? '';
$rol       = 'cliente';

$cliente = new Clientes();

// LISTAR
if ($accion === 'LISTAR') {
    $clientes = $cliente->crudCliente($accion, $id, $nombres, $apellidos, $telefono, $usuario, $rol);
    $tabla = '<table id="tablaListado" class="table table-bordered table-striped" style="font-size:1.08rem;background:rgba(255,255,255,0.92);border-radius:18px;box-shadow:0 2px 12px #2193b030;overflow:hidden;">'
        .'<thead>'
        .'<tr style="background:linear-gradient(90deg,#2193b0 0%,#6dd5ed 100%);color:#fff;font-weight:800;font-size:1.08rem;letter-spacing:0.5px;text-shadow:0 2px 8px #2193b080;text-align:center;padding:16px 10px;white-space:nowrap;border:none;">'
        .'<th>Nombres</th>'
        .'<th>Apellidos</th>'
        .'<th>Teléfono</th>'
        .'<th>Usuario</th>'
        .'<th>Rol</th>'
        .'<th>Acciones</th>'
        .'</tr>'
        .'</thead>'
        .'<tbody>';
    foreach ($clientes as $c) {
        $jsonCliente = htmlspecialchars(json_encode($c), ENT_QUOTES, 'UTF-8');
        $tabla .= "<tr data-cliente='{$jsonCliente}'>
                    <td>{$c['nombres']}</td>
                    <td>{$c['apellidos']}</td>
                    <td>{$c['telefono']}</td>
                    <td>{$c['usuario']}</td>
                    <td>{$c['rol']}</td>
                    <td>
                        <button class='btn btn-outline-info btn-sm rounded-pill shadow me-2' title='Editar'>
                          <i class='fas fa-edit'></i>
                        </button>
                        <button class='btn btn-outline-danger btn-sm rounded-pill shadow' title='Eliminar'>
                          <i class='fas fa-trash-alt'></i>
                        </button>
                    </td>
                  </tr>";
    }
    $tabla .= '</tbody></table>';
    ob_end_clean();
    echo $tabla;
    exit;
}

// ELIMINAR
if ($accion === 'ELIMINAR') {
    $resultado = $cliente->crudCliente($accion, $id, '', '', '', '', $rol);
    ob_end_clean();
    echo json_encode(["success" => $resultado]);
    exit;
}

// INSERTAR / MODIFICAR
if ($accion === 'INSERTAR' || $accion === 'MODIFICAR') {
    $datos = compact('nombres','apellidos','telefono','usuario','rol');
    $v = new Validator($datos);

    // Reglas de validación
    $v->rule('required',  ['nombres','apellidos','telefono','usuario','rol']);
    $v->rule('lengthMin', ['nombres','apellidos'], 2);

    // Solo letras y espacios en nombres y apellidos
    $v->rule('regex', ['nombres','apellidos'], '/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/')
      ->message('El campo {field} solo puede contener letras y espacios');

    // Teléfono: exactamente 10 dígitos numéricos
    $v->rule('regex', 'telefono', '/^[0-9]{10}$/')
      ->message('El teléfono debe tener exactamente 10 dígitos numéricos');

    // Usuario: 3–15 caracteres alfanuméricos, sin espacios ni símbolos
    $v->rule('regex', 'usuario', '/^[A-Za-z0-9]{3,15}$/')
      ->message('El usuario debe tener entre 3 y 15 caracteres, solo letras y números');

    $v->rule('in', 'rol', ['cliente']);

    if (!$v->validate()) {
        ob_end_clean();
        echo json_encode(['success' => false, 'errors' => $v->errors()]);
        exit;
    }

    $resultado = $cliente->crudCliente($accion, $id, $nombres, $apellidos, $telefono, $usuario, $rol);
    ob_end_clean();
    echo json_encode(["success" => $resultado]);
    exit;
}

// Acción no válida
ob_end_clean();
echo json_encode(['success' => false, 'errors' => ['acción' => ['Acción no válida']]]);
exit;
