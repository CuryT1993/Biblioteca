<?php
include('database.php');
include 'auth.php';

$id = $_GET['id'];
$query = "DELETE FROM inventario WHERE id = $id";
if (mysqli_query($conexion, $query)) {
    echo "<div class='alert alert-success'>Producto eliminado</div>";

    header("Location: inventario.php?");
} else {
    die("Error al eliminar: " . mysqli_error($conexion));
}
?>