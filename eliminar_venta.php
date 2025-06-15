<?php
include 'database.php';
include 'auth.php';

$id = $_GET['id'];

// Obtener los datos del movimiento
$sql = "SELECT * FROM movimientos WHERE id = $id";
$res = mysqli_query($conexion, $sql);
$mov = mysqli_fetch_assoc($res);

if ($mov && $mov['tipo'] == 'V') {
    $id_producto = $mov['id_producto'];
    $cantidad = $mov['cantidad'];

    // Eliminar el movimiento
    $sql_del = "DELETE FROM movimientos WHERE id = $id";
    mysqli_query($conexion, $sql_del);

    // Devolver la cantidad al stock del producto
    $sql_upd = "UPDATE productos SET cantidad = cantidad + $cantidad WHERE id = $id_libro";
    mysqli_query($conexion, $sql_upd);
}

// Redirigir a historial de ventas
header("Location: historial_ventas.php");
exit;
?>