<?php session_start(); 
include 'usuario_sesion.php';
include 'database.php';
include 'auth.php';

$result = mysqli_query($conexion, "SELECT * FROM usuarios");
$usuarios = [];
while ($row = mysqli_fetch_assoc($result)) {
    $usuarios[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Usuarios</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="css/icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">

        <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            Usuario guardado correctamente!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>


        <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            Usuario actualizado correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>



        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Usuarios</h1>

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
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Agregar Usuario
        </button>

        <!-- <a href="logout.php" class="btn btn-danger mb-2">
            Salir <i class="bi bi-box-arrow-right"></i>
        </a> -->

        <table id="usuariosTable" class="table table-striped table-hover w-100">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cédula</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>Tipo</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr data-id="<?= $usuario['id'] ?>">
                    <td><?= $usuario['id'] ?></td>
                    <td><?= $usuario['cedula'] ?></td>
                    <td><?= $usuario['apellidos'] ?></td>
                    <td><?= $usuario['nombres'] ?></td>
                    <td><?= $usuario['tipo'] ?></td>
                    <td><?= $usuario['email'] ?></td>
                    <td><?= $usuario['celular'] ?></td>
                    <td><?= $usuario['direccion'] ?></td>
                    <td><?= $usuario['estado'] ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm editBtn" data-id="<?= $usuario['id'] ?>"
                            data-cedula="<?= $usuario['cedula'] ?>" data-apellidos="<?= $usuario['apellidos'] ?>"
                            data-nombres="<?= $usuario['nombres'] ?>" data-tipo="<?= $usuario['tipo'] ?>"
                            data-email="<?= $usuario['email'] ?>" data-celular="<?= $usuario['celular'] ?>"
                            data-direccion="<?= $usuario['direccion'] ?>" data-estado="<?= $usuario['estado'] ?>">
                            Editar
                        </button>
                        <form action="delete_usuario.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Agregar Usuario -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="add_usuario.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Agregar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="cedula" class="form-label">Cédula:</label>
                                <input type="text" class="form-control" id="cedula" name="cedula" required
                                    pattern="\d{10}" maxlength="10" oninput="validarCedula(this)"
                                    title="Debe ingresar exactamente 10 números">
                                <small class="form-text text-muted">Ejemplo: 1234567890</small>
                                <div id="mensajeError" class="invalid-feedback">
                                    ¡La cédula debe tener 10 números!
                                </div>
                            </div>
                            <!--
                    <div class="mb-1">
                        <label for="cedula" class="form-label">Cédula:</label>
                        <input type="text" class="form-control" id="cedula" name="cedula" required>
                    </div>
                    -->
                            <!-- Repite para los demás campos -->
                            <div class="col-md-6">
                                <label for="apellidos" class="form-label">APELLIDOS:</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" required
                                    pattern="[A-Z\s]+" oninput="this.value = this.value.toUpperCase()"
                                    title="Solo se permiten letras mayúsculas y espacios">
                                <small class="form-text text-muted">Ejemplo: GARCÍA PÉREZ</small>
                                <div class="invalid-feedback">
                                    ¡Solo se permiten mayúsculas y espacios!
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="nombres" class="form-label">NOMBRES:</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" required
                                    pattern="[A-Z\s]+" oninput="this.value = this.value.toUpperCase()"
                                    title="Solo se permiten letras mayúsculas y espacios">
                                <small class="form-text text-muted">Ejemplo: ANA MARIA</small>
                                <div class="invalid-feedback">
                                    ¡Solo se permiten mayúsculas y espacios!
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">TIPO:</label>
                                <select name="tipo" class="form-select" required>
                                    <option value="Cliente">Cliente</option>
                                    <option value="Usuario">Usuario</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">CORREO:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="col-md-6">
                                <label for="celular" class="form-label">CELULAR:</label>
                                <input type="text" class="form-control" id="celular" name="celular" required>
                            </div>

                            <div class="col-md-6">
                                <label for="direccion" class="form-label">DIRECCIÓN:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                            <div class="col-md-12">
                                <label for="estado" class="form-label">ESTADO:</label>
                                <select name="estado" id="estado" class="form-select" required>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
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

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="update_usuario.php" method="post">
                    <input type="hidden" id="editUserId" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="editCedula" class="form-label">Cédula</label>
                                <input type="text" class="form-control" pattern="\d{10}" maxlength="10" id="editCedula"
                                    name="cedula" required>
                            </div>
                            <!-- Repite para los demás campos -->
                            <div class="col-md-6">
                                <label for="editApellidos" class="form-label">APELLIDOS:</label>
                                <input type="text" class="form-control" id="editApellidos" name="apellidos" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editNombres" class="form-label">NOMBRES:</label>
                                <input type="text" class="form-control" id="editNombres" name="nombres" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editEmail" class="form-label">EMAIL:</label>
                                <input type="text" class="form-control" id="editEmail" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editCelular" class="form-label">CELULAR:</label>
                                <input type="text" class="form-control" id="editCelular" name="celular" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editDireccion" class="form-label">DIRECCION:</label>
                                <input type="text" class="form-control" id="editDireccion" name="direccion" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editTipo" class="form-label">TIPO:</label>
                                <select id="editTipo" name="tipo" class="form-select" required>
                                    <option value="">Seleccione tipo</option>
                                    <option value="Cliente">Cliente</option>
                                    <option value="Usuario">Usuario</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editEstado" class="form-label">ESTADO:</label>
                                <select name="estado" id="editEstado" class="form-select" required>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
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
    $(document).ready(function() {
        $('#usuariosTable').DataTable({
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

        // Cargar datos en modal de edición
        $('.editBtn').on('click', function() {
            $('#editUserId').val($(this).data('id'));
            $('#editCedula').val($(this).data('cedula'));
            $('#editApellidos').val($(this).data('apellidos'));
            $('#editNombres').val($(this).data('nombres'));
            $('#editTipo').val($(this).data('tipo'));
            $('#editEmail').val($(this).data('email'));
            $('#editCelular').val($(this).data('celular'));
            $('#editDireccion').val($(this).data('direccion'));
            $('#editEstado').val($(this).data('estado'));

            $('#editUserModal').modal('show');
        });
    });
    </script>

    <!-- VALIDADOR DE CEDULA -->
    <script>
    function validarCedula(input) {
        // Eliminar caracteres no numéricos en tiempo real
        input.value = input.value.replace(/[^0-9]/g, '');

        // Validar longitud exacta de 10 dígitos
        const mensajeError = document.getElementById('mensajeError');
        if (input.value.length !== 10) {
            input.setCustomValidity('Longitud incorrecta');
            mensajeError.style.display = 'block';
        } else {
            input.setCustomValidity('');
            mensajeError.style.display = 'none';
        }
    }
    </script>

</body>

</html>