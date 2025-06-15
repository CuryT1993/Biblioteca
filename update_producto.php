<?php
include 'auth.php';

$host = "localhost";
$username = "root";
$password = "curytravez";
$database = "biblioteca";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) die("Conexión fallida: " . mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
    $categoria = mysqli_real_escape_string($conn, $_POST["editar_categoria"]);
    $marca = mysqli_real_escape_string($conn, $_POST["marca"]);
    $artista = mysqli_real_escape_string($conn, $_POST["artista"]);
    $stock = mysqli_real_escape_string($conn, $_POST["stock"]);
    $descripcion = mysqli_real_escape_string($conn, $_POST["descripcion"]);

    // Validaciones
    if (empty($id)) die("Error: ID requerido.");
    if (empty($nombre)) die("Error: Nombre requerido.");
    if (empty($categoria)) die("Error: Categoría requerida.");
    if (empty($stock)) die("Error: Stock requerido.");
    if (!is_numeric($stock) || $stock < 0) die("Error: Stock inválido.");

    // Verificar existencia del ID
    $sql_check = "SELECT * FROM inventario WHERE id = $id";
    $result = mysqli_query($conn, $sql_check);
    if (mysqli_num_rows($result) == 0) die("Error: Producto no encontrado.");

    // Actualizar con consulta preparada
    $stmt = $conn->prepare("UPDATE inventario SET 
                            nombre = ?, 
                            categoria = ?, 
                            marca = ?, 
                            artista = ?, 
                            stock = ?, 
                            descripcion = ? 
                            WHERE id = ?");
    $stmt->bind_param("ssssssi", $nombre, $categoria, $marca, $artista, $stock, $descripcion, $id);

    if ($stmt->execute()) {
   header('Location: inventario.php?updated=1');

    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

mysqli_close($conn);
?>