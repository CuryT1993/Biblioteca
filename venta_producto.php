<?php 
session_start();
include 'usuario_sesion.php';
include 'database.php';
include 'auth.php';
 ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Punto de Venta</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="css/icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap Bundle con Popper incluido -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</head>

<body class="container mt-4 ">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Punto de Venta</h1>

        <div class="dropdown d-flex align-items-center mt-2">
            <a class="dropdown-toggle text-decoration-none d-flex align-items-center gap-2" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-2x"></i>
                <?php if ($usuario): ?>
                <span class="d-flex flex-column text-start lh-sm">
                    <strong class="fw-semibold small"><?= htmlspecialchars($usuario['nombres']) ?></strong>
                    <small class="text-muted">(<?= htmlspecialchars($usuario['privilegio']) ?>)</small>
                </span>
                <?php endif; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <?php if ($usuario): ?>
                <li><a class="dropdown-item" href="#">Mi perfil</a></li>
                <li><a class="dropdown-item" href="seleccionar_destino.php">Ir a mi panel</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                <li><a class="dropdown-item" href="login.php">Acceso como</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <form method="POST" action="procesar_venta.php" id="formVenta" target="_blank">
        <div class="mb-3">
            <label for="cedula">Cédula del Cliente:</label>
            <input type="text" name="cedula" id="cedula" class="form-control" required>
            <button type="button" id="buscarCliente" class="btn btn-primary mt-2">Buscar Cliente</button>
            <!-- <a href="logout.php" class="btn btn-danger mt-2">
                Salir <i class="bi bi-box-arrow-right"></i>
            </a> -->
        </div>
        <div id="clienteDatos" class="mb-3"></div>

        <table class="table table-bordered" id="tablainventario">
            <thead class="table-dark">
                <tr>
                    <th>Seleccionar</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php
        $sql = "SELECT * FROM inventario WHERE cantidad > 0";
        $resultado = mysqli_query($conexion, $sql);
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td><input type='checkbox' name='inventario[]' value='".$fila['id']."'></td>";
            echo "<td>".$fila['nombre']."</td>";
            echo "<td>".$fila['precio']."</td>";
            echo "<td>".$fila['cantidad']."</td>";
            echo "<td><input type='number' name='cantidades[".$fila['id']."]' min='1' max='".$fila['cantidad']."' class='form-control'></td>";
            echo "</tr>";
        }
        ?>
            </tbody>
        </table>

        <input type="hidden" name="id_usuario" id="id_usuario">
        <button type="submit" class="btn btn-success">Procesar Venta</button>
    </form>

    <!-- Scripts JS -->
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap5.min.js"></script>

    <script>
    document.getElementById('formVenta').addEventListener('submit', function() {
        // Da tiempo a que el PDF se genere en nueva pestaña, luego recarga esta
        setTimeout(() => {
            location.reload();
        }, 1000); // 1 segundo después del envío
    });
    </script>

    <script>
    $(document).ready(function() {
        $('#tablainventario').DataTable({
            "pageLength": 5,
            "order": false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ inventario por página",
                "zeroRecords": "No se encontraron inventario",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ inventario",
                "infoEmpty": "Mostrando 0 a 0 de 0 inventario",
                "infoFiltered": "(filtrado de _MAX_ inventario totales)",
                "search": "Buscar:",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });

    $('#buscarCliente').click(function() {
        var cedula = $('#cedula').val();
        $.post("buscar_cliente.php", {
            cedula: cedula
        }, function(respuesta) {
            $('#clienteDatos').html(respuesta);
        });
    });
    </script>
</body>

</html>