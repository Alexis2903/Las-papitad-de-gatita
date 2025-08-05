<?php
require_once "../config/conexion.php";

class Producto {
  public function crudProducto($accion, $id, $nombre, $descripcion, $precio, $tiempo, $imagen, $nombre_evento, $fecha_evento) {
    global $conexion;

    $sql = "CALL sp_crud_productos(?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("Error al preparar: " . $conexion->error);
    }

    // LIMPIAR DATOS
    $id = (int)$id;
    $precio = (float)$precio;
    $tiempo = (int)$tiempo;

    $nombre_evento = ($nombre_evento === '') ? null : $nombre_evento;
    $fecha_evento = ($fecha_evento === '' || strtolower($fecha_evento) === 'null') ? null : $fecha_evento;

    // USAR 'bind_param' por referencia
    $stmt->bind_param("sissdisss", 
      $accion,
      $id,
      $nombre,
      $descripcion,
      $precio,
      $tiempo,
      $imagen,
      $nombre_evento,
      $fecha_evento
    );

    if (!$stmt->execute()) {
        die("Error al ejecutar: " . $stmt->error);
    }

    if ($accion === 'LISTAR') {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return true;
  }
}
?>
