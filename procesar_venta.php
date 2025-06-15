<?php
include 'database.php';
require 'fpdf/fpdf.php';
include 'auth.php';

$id_usuario    = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : 0;
$productos_ids = $_POST['inventario'] ?? [];
$cantidades    = $_POST['cantidades'] ?? [];
$fecha         = date('Y-m-d');

if ($id_usuario <= 0 || empty($productos_ids)) {
    die("Error: Datos incompletos para procesar la venta.");
}

// Obtener datos del cliente
$sql_cliente = "SELECT * FROM usuarios WHERE id = $id_usuario";
$res_cliente = mysqli_query($conexion, $sql_cliente);
$cliente     = mysqli_fetch_assoc($res_cliente);

if (! $cliente) {
    die("Error: Cliente no encontrado.");
}

$detalle_venta = [];

foreach ($productos_ids as $id_producto) {
    $id_producto = intval($id_producto);
    $cantidad    = intval($cantidades[$id_producto] ?? 0);

    if ($cantidad <= 0) {
        continue;
    }

    // Obtener datos del producto
    $sql       = "SELECT nombre, costo, precio, cantidad FROM inventario WHERE id = $id_producto";
    $resultado = mysqli_query($conexion, $sql);
    $producto  = mysqli_fetch_assoc($resultado);

    if (! $producto) {
        continue;
    }

    if ($producto['cantidad'] >= $cantidad) {
        $costo    = $producto['costo'];
        $precio   = $producto['precio'];
        $nombre   = $producto['nombre'];
        $subtotal = $precio * $cantidad;

        // Registrar el movimiento
        $sql_mov = "INSERT INTO movimientos (id_producto, id_usuario, tipo, cantidad, costo, precio, fecha)
                    VALUES ($id_producto, $id_usuario, 'V', $cantidad, $costo, $precio, '$fecha')";
        mysqli_query($conexion, $sql_mov);

        // Actualizar stock
        $sql_upd = "UPDATE inventario SET cantidad = cantidad - $cantidad WHERE id = $id_producto";
        mysqli_query($conexion, $sql_upd);

        // Agregar al detalle de factura
        $detalle_venta[] = [
            'nombre'   => $nombre,
            'cantidad' => $cantidad,
            'precio'   => $precio,
            'subtotal' => $subtotal,
        ];
    }
}

// Generar PDF si hay productos vendidos
if (count($detalle_venta) === 0) {
    die("No se vendió ningún producto válido.");
}

// ---------------------------
// FACTURA PDF
// ---------------------------
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'FACTURA DE VENTA', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Fecha: $fecha", 0, 1);
$pdf->Cell(0, 10, "Cliente: {$cliente['nombres']} {$cliente['apellidos']} - Cédula: {$cliente['cedula']}", 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 8, 'Producto', 1);
$pdf->Cell(20, 8, 'Cant', 1, 0, 'C');
$pdf->Cell(30, 8, 'Precio', 1, 0, 'R');
$pdf->Cell(40, 8, 'Subtotal', 1, 0, 'R');
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

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(150, 8, 'TOTAL', 1);
$pdf->Cell(40, 8, '$' . number_format($total, 2), 1, 0, 'R');

// Mostrar PDF
$pdf->Output('I', 'factura_' . $cliente['cedula'] . '_' . $fecha . '.pdf');
exit;