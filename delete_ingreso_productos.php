<?php
session_start();
include('database.php');
include 'auth.php';

$id_movimiento = $_GET['id'];

//PASO UNO: OBTENER LOS DATOS PARA ELIMINAR
$query_select = "SELECT id_productos, cantidad FROM movimientos WHERE id= '$id_movimiento' ";
$result = mysqli_query($conexion, $query_select);
$row = mysqli_fetch_assoc($result);
$id_productos = $row['id_productos'];
$cantidad = $row['cantidad'];

//PASO DOS: ELIMINAR INGRESO
$query_delete = "DELETE FROM movimientos WHERE id = '$id_movimiento' ";
mysqli_query($conexion, $query_delete);

//PASO TRES: ACTUALIZAR TABLA productosS
$query_update = "UPDATE productos SET cantidad = cantidad - '$cantidad' WHERE id = '$id_productos' ";
mysqli_query($conexion, $query_update);

//PASO CUATRO: CERRAR BASE DE DATOS
mysqli_close($conexion);

//PASO CINCO: REDIRECCIONAR PÀGINA
header("Location: ingreso_productos.php"); 
exit();
?>