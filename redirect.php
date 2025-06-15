<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['pagina'])) {
        $pagina = $_POST['pagina'];

        // Validar que la página seleccionada sea una de las permitidas
        $paginas_permitidas = ['inventario.php', 'usuarios.php', 'ingreso_productos.php', 'index.php', 'venta_producto.php'];
        if (in_array($pagina, $paginas_permitidas)) {
            header("Location: $pagina");
            exit();
        } else {
            // Redirigir a una página predeterminada si la selección no es válida
            header("Location: index.php");
            exit();
        }
    } else {
        // Redirigir a una página predeterminada si no se seleccionó ninguna opción
        header("Location: index.php");
        exit();
    }
}
