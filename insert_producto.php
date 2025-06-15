<?php
session_start();
include('database.php');




$campos = [
    'nombre'      => mysqli_real_escape_string($conexion, $_POST['nombre']),
    'categoria'   => mysqli_real_escape_string($conexion, $_POST['categoria']),
    'marca'       => mysqli_real_escape_string($conexion, $_POST['marca']),
    'artista'     => mysqli_real_escape_string($conexion, $_POST['artista']),
    'stock'       => (int) $_POST['stock'], // convertir directamente a int
    'cantidad'    => (int) $_POST['stock'],
    'descripcion' => mysqli_real_escape_string($conexion, $_POST['descripcion']),
];

// Costo y precio: convertir a float o null según corresponda
$costo            = trim($_POST['costo']);
$precio           = trim($_POST['precio']);
$campos['costo']  = $costo === '' ? 0 : floatval($costo);
$campos['precio'] = $precio === '' ? 0 : floatval($precio);

// Construir columnas y valores con tratamiento para NULL
$columnas = implode(', ', array_keys($campos));
$valores  = implode(', ', array_map(function ($valor) use ($conexion) {
    if (is_null($valor)) {
        return "NULL";
    } elseif (is_numeric($valor)) {
        return $valor;
    } else {
        return "'" . mysqli_real_escape_string($conexion, $valor) . "'";
    }
}, $campos));

$query = "INSERT INTO inventario ($columnas) VALUES ($valores)";

if (mysqli_query($conexion, $query)) {

    header('Location: inventario.php?success=1');

    exit;
} else {
    echo "Error al insertar: " . mysqli_error($conexion);
}