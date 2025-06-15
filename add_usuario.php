<?php
include 'database.php';
include 'auth.php';

$cedula    = $_POST['cedula'];
$apellidos = $_POST['apellidos'];
$nombres   = $_POST['nombres'];
$tipo      = $_POST['tipo'];
$email     = $_POST['email'];
$celular   = $_POST['celular'];
$direccion = $_POST['direccion'];
$estado    = $_POST['estado'];


$stmt = mysqli_prepare($conexion, "INSERT INTO usuarios 
    (cedula, apellidos, nombres, tipo, email, celular, direccion, estado)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($stmt, 'ssssssss', $cedula, $apellidos, $nombres, $tipo, $email, $celular, $direccion, $estado);
mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);
mysqli_close($conexion);

header('Location: usuarios.php?success=1');

exit();
?>