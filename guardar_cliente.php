<?php
include 'database.php';

$cedula = $_POST['cedula'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];

$sql = "INSERT INTO usuarios (cedula, apellidos, nombres, tipo, email, telefono, direccion, estado)
        VALUES ('$cedula', '$apellidos', '$nombres', 'cliente', '$email', '$telefono', '$direccion', 'Activo')";
mysqli_query($conexion, $sql);

$id_usuario = mysqli_insert_id($conexion);

echo "<div class='alert alert-success'>Cliente registrado: $nombres $apellidos</div>";
echo "<script>document.getElementById('id_usuario').value = '$id_usuario';</script>";
?>