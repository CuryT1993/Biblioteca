<?php
include 'database.php';
require('fpdf/fpdf.php');
include 'auth.php';

$id_usuario = $_POST['id_usuario'];
$productos = $_POST['productos'];
$cantidades = $_POST['cantidades'];
$fecha = date('Y-m-d');

// Obtener datos del cliente
$sql_cliente = "SELECT * FROM usuarios WHERE id = $id_usuario";
$res_cliente = mysqli_query($conexion, $sql_cliente);
$cliente = mysqli_fetch_assoc($res_cliente);

// Array para guardar los productos comprados
$detalle_venta = [];

foreach ($productos as $id_productos) {
    $cantidad = intval($cantidades[$id_productos]);

    // Obtener precio y stock actual
    $sql = "SELECT nombre, costo, precio, cantidad FROM productos WHERE id = $id_productos";
    $resultado = mysqli_query($conexion, $sql);
    $productos = mysqli_fetch_assoc($resultado);

    if ($productos['cantidad'] >= $cantidad && $cantidad > 0) {
        $costo = $productos['costo'];
        $precio = $productos['precio'];
        $nombre = $productos['nombre'];
        $subtotal = $precio * $cantidad;

        // Insertar movimiento
        $sql_mov = "INSERT INTO movimientos (id_productos, id_usuario, tipo, cantidad, costo, precio, fecha)
                    VALUES ($id_productos, $id_usuario, 'V', $cantidad, $costo, $precio, '$fecha')";
        mysqli_query($conexion, $sql_mov);

        // Actualizar stock
        $sql_upd = "UPDATE productos SET cantidad = cantidad - $cantidad WHERE id = $id_productos";
        mysqli_query($conexion, $sql_upd);

        // Guardar para factura
        $detalle_venta[] = [
            'nombre' => $nombre,
            'cantidad' => $cantidad,
            'precio' => $precio,
            'subtotal' => $subtotal
        ];
    }
}

// Generar factura con FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'FACTURA DE VENTA', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Fecha: $fecha", 0, 1);
$pdf->Cell(0, 10, "Cliente: {$cliente['nombres']} {$cliente['apellidos']} - Cedula: {$cliente['cedula']}", 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 8, 'productos', 1);
$pdf->Cell(20, 8, 'Cant', 1);
$pdf->Cell(30, 8, 'Precio', 1);
$pdf->Cell(40, 8, 'Subtotal', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
$total = 0;
foreach ($detalle_venta as $item) {
    $pdf->Cell(100, 8, $item['nombre'], 1);
    $pdf->Cell(20, 8, $item['cantidad'], 1, 0, 'C');
    $pdf->Cell(30, 8, '$' . number_format($item['precio'], 2), 1, 0, 'R');
    $pdf->Cell(40, 8, '$' . number_format($item['subtotal'], 2), 1, 0, 'R');
    $pdf->Ln();
    $total += $item['subtotal'];
}

$pdf->Cell(150, 8, 'TOTAL', 1);
$pdf->Cell(40, 8, '$' . number_format($total, 2), 1, 0, 'R');

// Salida del PDF
$pdf->Output('I', 'factura_'.$cliente['cedula'].'_'.$fecha.'.pdf'); // Mostrar en navegador
exit;
?>