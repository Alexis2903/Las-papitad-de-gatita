<?php
require_once "../config/conexion.php";
require_once "../modelos/productos.php";
require_once __DIR__ . '/../vendor/autoload.php';
use Valitron\Validator;

Validator::lang('es');
ini_set('display_errors', 0);
error_reporting(0);
ob_start();

$accion = $_POST['accion'] ?? '';
$id = $_POST['id_producto'] ?? 0;
$nombre = $_POST['nombre'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$precio = $_POST['precio'] ?? 0;
$tiempo = $_POST['tiempo_preparacion'] ?? 0;
$imagen_actual = $_POST['imagen_actual'] ?? '';
$nombre_evento = $_POST['nombre_evento'] ?? '';
$fecha_evento = $_POST['fecha_evento'] ?? null;

$producto = new Producto();

// Subir imagen
$nombreImagen = $imagen_actual;
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $ruta = "../vistas/imagenes/";
    $nombreImagen = uniqid() . "_" . basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta . $nombreImagen);
}

// LISTAR
if ($accion === 'LISTAR') {
    $productos = $producto->crudProducto($accion, $id, $nombre, $descripcion, $precio, $tiempo, $nombreImagen, $nombre_evento, $fecha_evento);
    $tabla = '<thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Tiempo</th>
            <th>Evento</th>
            <th>Imagen</th>
            <th>Acción</th>
        </tr>
    </thead><tbody>';

    foreach ($productos as $p) {
        $jsonProducto = htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8');
        $tabla .= "<tr>
            <td>{$p['nombre']}</td>
            <td>{$p['descripcion']}</td>
            <td>$" . number_format($p['precio'], 2) . "</td>
            <td>{$p['tiempo_preparacion']} min</td>
            <td>{$p['nombre_evento']}</td>
            <td><img src='../vistas/imagenes/{$p['imagen']}' width='60' class='rounded shadow'></td>
            <td>
                <button class='btn btn-outline-info btn-sm rounded-pill shadow me-2' title='Editar' onclick='cargar({$jsonProducto})'>
                  <i class='fas fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger btn-sm rounded-pill shadow' title='Eliminar' onclick='eliminar({$p['id_producto']})'>
                  <i class='fas fa-trash-alt'></i>
                </button>
            </td>
        </tr>";
    }

    $tabla .= '</tbody>';
    ob_end_clean();
    echo $tabla;
    exit;
}

// ELIMINAR
if ($accion === 'ELIMINAR') {
    $res = $producto->crudProducto($accion, $id, '', '', 0, 0, '', '', null);
    ob_end_clean();
    echo json_encode(['success' => $res]);
    exit;
}

// INSERTAR / MODIFICAR
if ($accion === 'INSERTAR' || $accion === 'MODIFICAR') {
    $datos = compact('nombre', 'descripcion', 'precio', 'tiempo', 'nombre_evento', 'fecha_evento');
    $v = new Validator($datos);

    $v->rule('required', ['nombre', 'descripcion', 'precio', 'tiempo']);
    $v->rule('lengthMin', 'nombre', 2);
    $v->rule('regex', 'nombre', '/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/')
      ->message('El campo {field} solo puede contener letras y espacios');
    $v->rule('numeric', ['precio', 'tiempo']);
    $v->rule('min', 'precio', 0.01)->message('El precio debe ser mayor que 0');
    $v->rule('min', 'tiempo', 1)->message('El tiempo debe ser mayor que 0');

    if (!$v->validate()) {
        ob_end_clean();
        echo json_encode(['success'=>false,'errors'=>$v->errors()]);
        exit;
    }

    $res = $producto->crudProducto($accion, $id, $nombre, $descripcion, $precio, $tiempo, $nombreImagen, $nombre_evento, $fecha_evento);
    ob_end_clean();
    echo json_encode(['success' => $res]);
    exit;
}
if ($accion === 'LISTAR_EVENTOS') {
    $sql = "SELECT DISTINCT nombre_evento, fecha_evento FROM productos WHERE nombre_evento IS NOT NULL AND nombre_evento != ''";
    $result = $conexion->query($sql);
    $eventos = [];

    while ($row = $result->fetch_assoc()) {
        $eventos[] = $row;
    }

    ob_end_clean();
    echo json_encode($eventos);
    exit;
}


// ACCIÓN NO VÁLIDA
ob_end_clean();
echo json_encode(['success'=>false,'errors'=>['accion'=>['Acción no válida']]]);
exit;
