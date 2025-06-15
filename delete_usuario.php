<?php
include 'database.php';
include 'auth.php';

$id = $_POST['id'];

$stmt = mysqli_prepare($conexion, "DELETE FROM usuarios WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);
mysqli_close($conexion);

header('Location: usuarios.php');
exit();
?>