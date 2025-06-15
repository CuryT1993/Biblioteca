<?php 
session_start(); 
include 'usuario_sesion.php';
include('database.php'); 
include 'auth.php';



// Consultar inventario ordenado por nombre del producto
$query1 = "SELECT id, nombre FROM inventario ORDER BY nombre ASC";
$result1 = mysqli_query($conexion, $query1);
if (!$result1) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestor de Productos</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="css/icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
    body {
        padding-top: 20px;
    }

    .modal-lg {
        max-width: 700px;
    }

    .table thead th {
        vertical-align: middle;
    }
    </style>
</head>

<body class="container mt-5">
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        Producto ingresado correctamente!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    <?php if (isset($_GET['update'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        Producto de ingreso actualizado correctamente!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Ingreso de nuevos productos</h1>

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



    <a href="javascript:history.back()" class="btn btn-warning mb-2">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
    <br>
    <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#nuevoIngreso">
        Nuevo Ingreso <i class="bi bi-plus-circle"></i>
    </button>
    <!-- <a href="logout.php" class="btn btn-danger mb-2">
        Salir <i class="bi bi-box-arrow-right"></i>
    </a> -->
    <div class="table-responsive-lg">
        <table id="tablaProductos" class="table table-striped table-hover w-100">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>ID Producto</th>
                    <th>Descripción</th>
                    <th>Artista</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
                    <th>Precio</th>
                    <th>Costo/Precio</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta actualizada para usar inventario + movimientos
                $query = "SELECT m.id, inv.nombre, inv.artista, m.id_producto, m.cantidad, m.costo, m.precio, m.fecha
                          FROM inventario inv
                          INNER JOIN movimientos m ON m.id_producto = inv.id
                          ORDER BY m.fecha DESC";
                $result = mysqli_query($conexion, $query);
                if (!$result) {
                    die("Error en la consulta: " . mysqli_error($conexion));
                }
                while($fila = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                    <td><?= htmlspecialchars($fila['id']) ?></td>
                    <td><?= htmlspecialchars($fila['id_producto']) ?></td>
                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td><?= htmlspecialchars($fila['artista']) ?></td>
                    <td><?= htmlspecialchars($fila['cantidad']) ?></td>
                    <td><?= number_format($fila['costo'], 2) ?></td>
                    <td><?= number_format($fila['precio'], 2) ?></td>
                    <td><?= number_format($fila['cantidad'] * $fila['costo'], 2) ?></td>
                    <td><?= htmlspecialchars($fila['fecha']) ?></td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editarIngreso" onclick="CargarDatosProductos(
                                    <?= (int)$fila['id'] ?>,
                                    <?= (int)$fila['id_producto'] ?>,
                                    '<?= addslashes(htmlspecialchars($fila['nombre'])) ?>',
                                    <?= (int)$fila['cantidad'] ?>,
                                    <?= number_format($fila['costo'], 2, '.', '') ?>,
                                    <?= number_format($fila['precio'], 2, '.', '') ?>
                                )">
                            Editar
                        </button>
                        <a href="delete_ingreso_productos.php?id=<?= (int)$fila['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿ELIMINAR INGRESO: <?= addslashes(htmlspecialchars($fila['nombre'])) ?>?')">
                            Eliminar
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <!-- Modal Nuevo Ingreso -->
    <div class="modal fade" id="nuevoIngreso" tabindex="-1" aria-labelledby="nuevoIngresoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="insert_ingreso_producto.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuevoIngresoLabel">Nuevo Ingreso de productos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Campo: producto -->
                            <div class="col-md-12">
                                <label for="id_producto" class="form-label">Producto:</label>
                                <select name="id_producto" id="id_producto" class="form-select" required>
                                    <option value="">Seleccione un producto</option>
                                    <?php if (mysqli_num_rows($result1) > 0): ?>
                                    <?php while ($row1 = mysqli_fetch_assoc($result1)): ?>
                                    <option value="<?= (int)$row1['id'] ?>"><?= htmlspecialchars($row1['nombre']) ?>
                                    </option>
                                    <?php endwhile; ?>
                                    <?php else: ?>
                                    <option value="">No hay productos disponibles</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="cantidad" class="form-label">Cantidad:</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" min="1"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="costo" class="form-label">Costo:</label>
                                <input type="number" name="costo" id="costo" class="form-control" step="0.01" min="0"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="precio" class="form-label">Precio:</label>
                                <input type="number" name="precio" id="precio" class="form-control" step="0.01" min="0"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Editar -->
    <div class="modal fade" id="editarIngreso" tabindex="-1" aria-labelledby="editarIngresoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formEditarIngreso" method="POST" action="update_ingreso_producto.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarIngresoLabel">Editar Ingreso de producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" />
                        <div class="row g-3">
                            <!-- Campo: producto (solo lectura) -->
                            <div class="col-md-6">
                                <label for="edit_id_producto" class="form-label">ID Producto:</label>
                                <input type="number" name="id_producto" id="edit_id_producto" class="form-control"
                                    readonly />
                            </div>
                            <div class="col-md-6">
                                <label for="nombre_producto" class="form-label">Producto:</label>
                                <input type="text" id="nombre_producto" class="form-control" readonly />
                            </div>
                            <!-- Campos editables -->
                            <div class="col-md-6">
                                <label for="edit_cantidad" class="form-label">Cantidad:</label>
                                <input type="number" name="cantidad" id="edit_cantidad" class="form-control" min="1"
                                    required />
                            </div>
                            <div class="col-md-6">
                                <label for="edit_costo" class="form-label">Costo:</label>
                                <input type="number" name="costo" id="edit_costo" class="form-control" step="0.01"
                                    min="0" required />
                            </div>
                            <div class="col-md-6">
                                <label for="edit_precio" class="form-label">Precio:</label>
                                <input type="number" name="precio" id="edit_precio" class="form-control" step="0.01"
                                    min="0" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap5.min.js"></script>
    <script>
    function CargarDatosProductos(id, id_producto, nombre, cantidad, costo, precio) {
        document.getElementById('id').value = id;
        document.getElementById('edit_id_producto').value = id_producto;
        document.getElementById('nombre_producto').value = nombre;
        document.getElementById('edit_cantidad').value = cantidad;
        document.getElementById('edit_costo').value = costo;
        document.getElementById('edit_precio').value = precio;
    }
    </script>
    <script>
    $(document).ready(function() {
        $('#tablaProductos').DataTable({
            "language": {
                "url": "js/es-ES.json"
            },
            pageLength: 5,
            lengthMenu: [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, 'Todos']
            ],
            pagingType: 'full_numbers',
            responsive: true
        });
    });
    </script>
</body>

</html>