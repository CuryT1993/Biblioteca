<?php
session_start();
include 'usuario_sesion.php';
include 'database.php';
include 'auth.php';


if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "SELECT * FROM inventario WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($fila = $result->fetch_assoc()) {
        echo json_encode($fila);
    } else {
        echo json_encode(["error" => "No se encontró el producto"]);
    }
}
?>