<?php
session_start();
include('database.php');
include 'auth.php';

// RECUPERAR INFORMACIÓN
$id_movimiento = $_POST['id'];
$id_producto = $_POST['id_producto'];
$cantidad = $_POST['cantidad'];
$costo = $_POST['costo'];
$precio = $_POST['precio'];

// PASO UNO: OBTENER DATOS ANTERIORES
$query_old = "SELECT cantidad FROM movimientos WHERE id='$id_movimiento' AND id_producto='$id_producto'";
$result_old = mysqli_query($conexion, $query_old);
$row_old = mysqli_fetch_assoc($result_old);
$cantidad_old = $row_old['cantidad'];

// PASO DOS: CALCULAR DIFERENCIA
$cantidad_actual = $cantidad - $cantidad_old;

// PASO TRES: ACTUALIZAR LA TABLA INVENTARIO (antes era productos)
$query_libros = "UPDATE inventario SET cantidad = cantidad + '$cantidad_actual' WHERE id ='$id_producto'";
mysqli_query($conexion, $query_libros);

// PASO CUATRO: ACTUALIZAR TABLA MOVIMIENTOS
$query_update = "UPDATE movimientos 
SET 
cantidad = '$cantidad', 
costo = '$costo', 
precio = '$precio' 
WHERE id = '$id_movimiento' ";
mysqli_query($conexion, $query_update);

// PASO CINCO: CERRAR BD
mysqli_close($conexion);

// PASO SEIS: REDIRECCIONAR 

header("Location: ingreso_productos.php?update=1");

exit();
?>