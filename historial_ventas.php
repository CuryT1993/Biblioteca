<?php include 'database.php';
include 'auth.php';
 ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de Ventas</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body class="container py-4">

    <h3>Historial de Ventas</h3>

    <form method="POST" class="mb-4">
        <label>Cédula del Cliente:</label>
        <input type="text" name="cedula" class="form-control" required>
        <button class="btn btn-primary mt-2" type="submit">Consultar</button>
        <a href="javascript:history.back()" class="btn btn-danger mt-2">
            Salir <i class="bi bi-box-arrow-right"></i>
        </a>
    </form>

    <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $sql_usuario = "SELECT * FROM usuarios WHERE cedula = '$cedula'";
    $res_usuario = mysqli_query($conexion, $sql_usuario);

    if (mysqli_num_rows($res_usuario) > 0) {
        $usuario = mysqli_fetch_assoc($res_usuario);
        $id_usuario = $usuario['id'];

        echo "<h5>Ventas a: {$usuario['nombres']} {$usuario['apellidos']}</h5>";

        $sql = "SELECT movimientos.id, productos.nombre, movimientos.cantidad, movimientos.precio, movimientos.fecha
                FROM movimientos 
                INNER JOIN productos ON movimientos.id_libro = productos.id 
                WHERE movimientos.id_usuario = $id_usuario AND movimientos.tipo = 'V'
                ORDER BY movimientos.fecha DESC";

        $res = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($res) > 0) {
            echo '<table class="table table-bordered" id="tablaVentas">';
            echo '<thead><tr><th>Título</th><th>ID</th><th>Cantidad</th><th>Precio</th><th>Fecha</th><th>Acción</th></tr></thead><tbody>';
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>";
                echo "<td>".$row['nombre']."</td>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['cantidad']."</td>";
                echo "<td>".$row['precio']."</td>";
                echo "<td>".$row['fecha']."</td>";
                echo "<td><a href='eliminar_venta.php?id=".$row['id']."' class='btn btn-danger btn-sm' onclick=\"return confirm('¿Deseas eliminar esta venta?');\">Eliminar</a></td>";
                echo "</tr>";
            }
            echo '</tbody></table>';
        } else {
            echo "<div class='alert alert-warning'>Este cliente no tiene ventas registradas.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Cliente no encontrado.</div>";
    }
}
?>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#tablaVentas').DataTable({
            "pageLength": 5,
            "language": {
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_",
                "info": "Mostrando _START_ a _END_ de _TOTAL_",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "zeroRecords": "No se encontraron ventas"
            }
        });
    });
    </script>
</body>

</html>