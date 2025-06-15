<?php
    session_start();
    include 'usuario_sesion.php';
    include 'auth.php';
   

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Selecciona destino</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title text-center">¡Bienvenido!</h5>
                <p class="card-text text-center">Selecciona una página para continuar:</p>
                <form method="POST" action="redirect.php" class="text-center">
                    <div class="mb-3">
                        <select name="pagina" id="pagina" class="form-select">
                            <option value="inventario.php">Inventario</option>
                            <option value="usuarios.php">Usuarios</option>
                            <option value="ingreso_productos.php">Ingreso Productos</option>


                            <option value="index.php">Inicio</option>
                            <option value="venta_producto.php">Punto de venta</option>

                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Ir</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>