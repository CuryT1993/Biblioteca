<?php
include 'auth.php';
include 'database.php';

$id        = $_POST['id'];
$cedula    = $_POST['cedula'];
$apellidos = $_POST['apellidos'];
$nombres   = $_POST['nombres'];
$tipo      = $_POST['tipo'];
$email     = $_POST['email'];
$celular   = $_POST['celular'];
$direccion = $_POST['direccion'];
$estado    = $_POST['estado'];

$stmt = mysqli_prepare($conexion, "UPDATE usuarios SET
    cedula = ?,
    apellidos = ?,
    nombres = ?,
    tipo = ?,
    email = ?,
    celular = ?,
    direccion = ?,
    estado = ?
    WHERE id = ?");

mysqli_stmt_bind_param($stmt, 'ssssssssi',
    $cedula, $apellidos, $nombres, $tipo,
    $email, $celular, $direccion, $estado, $id
);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);
mysqli_close($conexion);

// Redirige con mensaje opcional
header('Location: usuarios.php?updated=1');
exit();