<?php
session_start();
include('database.php');
include 'auth.php';

$id_producto = $_POST['id_producto'];
$cantidad = $_POST['cantidad'];
$costo = $_POST['costo'];
$precio = $_POST['precio'];
$fecha = date('Y-m-d');

/* Insertar registro en tabla movimientos */ 
$query = "INSERT INTO movimientos (id_producto, cantidad, costo, precio, fecha) 
VALUES ('$id_producto', '$cantidad', '$costo', '$precio', '$fecha')";
mysqli_query($conexion, $query);

/* Actualizar la tabla inventario (antes era productos) */  
$update_query = "UPDATE inventario SET 
cantidad = cantidad + '$cantidad', 
costo = '$costo', 
precio = '$precio'
WHERE id = '$id_producto'";
mysqli_query($conexion, $update_query);

mysqli_close($conexion);
header("Location: ingreso_productos.php?success=1");
exit();
?>