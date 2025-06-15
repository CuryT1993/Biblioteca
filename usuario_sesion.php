<?php

include('database.php');


$usuario = null;

if (isset($_SESSION['usuario_id'])) {
    $id = $_SESSION['usuario_id'];
    $consulta = "SELECT nombres, privilegio FROM accesos WHERE id = $id";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado && mysqli_num_rows($resultado) === 1) {
        $usuario = mysqli_fetch_assoc($resultado);
    }
}
?>