<?php
session_start();
include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['cedula']) || empty($_POST['clave'])) {
        $error = 'Debe ingresar cédula y clave';
    }else{
        // Escapar caracteres especiales
        $cedula = mysqli_real_escape_string($conexion, $_POST['cedula']);
        $clave = mysqli_real_escape_string($conexion, $_POST['clave']);
            
        // Consulta SQL
        $sql = "SELECT id FROM accesos WHERE cedula = '$cedula' AND clave = '$clave' AND activo = 'SI'";
        $resultado = mysqli_query($conexion, $sql);
        
        if (mysqli_num_rows($resultado) == 1) {
            $row = mysqli_fetch_assoc($resultado);
            $_SESSION['usuario_id'] = $row['id'];

         header("Location: seleccionar_destino.php");
     exit();
            
        } else {
            $_SESSION['login_error'] = "Credenciales incorrectas o usuario inactivo.";
            header("Location: login.php");
            exit();
        }
    }   
    mysqli_close($conexion);
} 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Iniciar Sesión</h3>

                        <?php if (isset($_SESSION['login_error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?php
            echo $_SESSION['login_error'];
            unset($_SESSION['login_error']);
        ?>
                        </div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="cedula" class="form-label">Cédula</label>
                                <input type="text" class="form-control" id="cedula" name="cedula" required>
                            </div>
                            <div class="mb-3">
                                <label for="clave" class="form-label">Clave</label>
                                <input type="password" class="form-control" id="clave" name="clave" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>