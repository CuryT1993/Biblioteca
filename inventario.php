<?php     
session_start(); 
include 'usuario_sesion.php';

include('database.php'); 

 include('auth.php'); 
 
 ?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inventario</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="css/icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="container">
    <?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        Producto guardado correctamente!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    <?php if (isset($_GET['updated'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        Producto actualizado correctamente!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Catálogo Digital</h1>

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
    <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#nuevoProducto">
        Nuevo Producto <i class="bi bi-plus-circle"></i>
    </button>
    <a href="productos_pdf.php" class="btn btn-primary mb-2">
        Generar PDF <i class="bi bi-file-pdf"></i>
    </a>
    <!-- <a href="logout.php" class="btn btn-danger mb-2">
        Salir <i class="bi bi-box-arrow-right"></i>
    </a> -->


    <!-- Dropdown de usuario -->
    <!-- Dropdown de usuario alineado a la derecha -->


    <!--visualizacion de registros en una tabla-->
    <div class="table-responsive-lg">
        <table id="tablainventario" class="table table-striped table-hover w-100">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>CATEGORIA</th>
                    <th>MARCA</th>
                    <th>ARTISTA</th>
                    <th>STOCK</th>
                    <th>DESCRIPCION</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM inventario";
                $result = mysqli_query($conexion, $query);
                while($fila = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                    <td><?= $fila['id'] ?></td>
                    <td><?= $fila['nombre'] ?></td>
                    <td><?= $fila['categoria'] ?></td>
                    <td><?= $fila['marca'] ?></td>
                    <td><?= $fila['artista'] ?></td>
                    <td><?= $fila['stock'] ?></td>
                    <td><?= $fila['descripcion'] ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning editar"
                            data-id="<?= htmlspecialchars($fila['id'], ENT_QUOTES, 'UTF-8') ?>" data-bs-toggle="modal"
                            data-bs-target="#editarinventario">
                            Editar
                        </button>
                        <a href="delete_producto.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿ELIMINAR producto: <?= addslashes($fila['nombre']) ?>?')">
                            Eliminar
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!--INSERTAR NUEVOS REGISTROS-->
    <div class="modal fade" id="nuevoproducto">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="insert_producto.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo inventario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <!--PRIMERA FILA-->
                            <div class="col-md-6">
                                <label for="nombre">NOMBRE:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="categoria">CATEGORÍA:</label>
                                <select name="categoria" id="categoria" class="form-control" required>
                                    <option value="">Seleccionar categoría</option>
                                    <option value="comida">Comida</option>
                                    <option value="bebidas">Bebidas</option>
                                    <option value="album">Álbum</option>
                                    <option value="merch">Merch</option>
                                </select>
                            </div>
                            <!--SEGUNDA FILA-->
                            <div class="col-md-6">
                                <label for="marca">MARCA:</label>
                                <input type="text" name="marca" id="marca" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="artista">ARTISTA:</label>
                                <input type="text" name="artista" id="artista" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="stock">STOCK:</label>
                                <input type="number" name="stock" id="stock" class="form-control" required>
                            </div>
                            <!--Tercera Fila-->
                            <div class="col-md-6">
                                <label for="descripcion">DESCRIPCION:</label>
                                <input type="text" name="descripcion" id="descripcion" class="form-control" required>
                            </div>
                            <!-- <div class="col-md-6">
                                <label for="costo">COSTO:</label>
                                <input type="number" name="costo" id="costo" class="form-control" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label for="precio">PRECIO:</label>
                                <input type="number" name="precio" id="precio" class="form-control" step="0.01"
                                    required>
                            </div> -->
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary">GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="editarinventario">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="update_producto.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <input type="hidden" name="id" id="editar_id">
                            <!-- Los mismos campos que el modal nuevo -->
                            <!-- Ejemplo para un campo -->
                            <div class="col-md-6">
                                <label>NOMBRE:</label>
                                <input type="text" name="nombre" id="editar_nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editar_categoria">CATEGORÍA:</label>
                                <select name="editar_categoria" id="editar_categoria" class="form-control" required>
                                    <option value="">Seleccionar categoría</option>
                                    <option value="comida">Comida</option>
                                    <option value="bebidas">Bebidas</option>
                                    <option value="album">Álbum</option>
                                    <option value="merch">Merch</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>MARCA:</label>
                                <input type="text" name="marca" id="editar_marca" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>ARTISTA:</label>
                                <input type="text" name="artista" id="editar_artista" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>STOCK:</label>
                                <input type="text" name="stock" id="editar_stock" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>DESCRIPCION:</label>
                                <input type="text" name="descripcion" id="editar_descripcion" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--LIBRERIAS JS-->
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap5.min.js"></script>

    <!--CONFIGURAR DATATABLE-->
    <script>
    $(document).ready(function() {
        $('#tablainventario').DataTable({
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

        $('.editar').click(function() {
            let id = $(this).data('id');
            $.post('view_producto.php', {
                id: id
            }, function(data) {
                $('#editar_id').val(data.id);
                $('#editar_nombre').val(data.nombre);
                $('#editar_categoria').val(data.categoria);
                $('#editar_marca').val(data.marca);
                $('#editar_stock').val(data.stock);
                $('#editar_artista').val(data.artista);
                $('#editar_descripcion').val(data.descripcion);
            }, 'json');
        });
    });
    </script>
</body>

</html>