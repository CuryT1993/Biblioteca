<?php
include 'database.php';

// Validación de entrada
if (!isset($_POST['cedula']) || empty($_POST['cedula'])) {
    die("<div class='alert alert-danger'>Cédula no válida</div>");
}

$cedula = mysqli_real_escape_string($conexion, $_POST['cedula']); // Sanitización
$sql = "SELECT * FROM usuarios WHERE cedula = '$cedula'";
$resultado = mysqli_query($conexion, $sql);

// Manejo de errores de consulta
if (!$resultado) {
    die("<div class='alert alert-danger'>Error en la consulta: " . mysqli_error($conexion) . "</div>");
}

if (mysqli_num_rows($resultado) > 0) {
    $usuario = mysqli_fetch_assoc($resultado);
    // Escapar salida para prevenir XSS
    echo "<div class='alert alert-success'>Cliente encontrado: " . htmlspecialchars($usuario['nombres']) . " " . htmlspecialchars($usuario['apellidos']) . "</div>";
    // Usar DOMContentLoaded para evitar problemas con elementos no cargados
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('id_usuario').value = '" . htmlspecialchars($usuario['id']) . "';
    });
    </script>";
} else {
    ?>
    <div class="alert alert-warning">Cliente no encontrado. Regístrelo:</div>
    <div>
        <input type="text" id="nombres" class="form-control mt-2" placeholder="Nombres">
        <input type="text" id="apellidos" class="form-control mt-2" placeholder="Apellidos">
        <input type="text" id="telefono" class="form-control mt-2" placeholder="Teléfono (opcional)">
        <input type="email" id="email" class="form-control mt-2" placeholder="Email (opcional)">
        <input type="text" id="direccion" class="form-control mt-2" placeholder="Dirección (opcional)">
        <button class="btn btn-info mt-2" onclick="registrarCliente()">Registrar Cliente</button>
    </div>

    <script>
    function registrarCliente() {
        // Validación básica del lado del cliente
        const nombres = $('#nombres').val().trim();
        const apellidos = $('#apellidos').val().trim();
        
        if (!nombres || !apellidos) {
            alert('Por favor complete los campos obligatorios');
            return;
        }

        $.post("guardar_cliente.php", {
            cedula: $('#cedula').val(),
            nombres: nombres,
            apellidos: apellidos,
            telefono: $('#telefono').val(),
            email: $('#email').val(),
            direccion: $('#direccion').val()
        }, function(respuesta) {
            $('#clienteDatos').html(respuesta);
            // Limpiar campos después de registrar
            $('#nombres, #apellidos, #telefono, #email, #direccion').val('');
        }).fail(function() {
            $('#clienteDatos').html('<div class="alert alert-danger">Error al registrar el cliente</div>');
        });
    }
    </script>
    <?php
}
?>