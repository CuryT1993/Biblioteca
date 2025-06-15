<?php
require('database.php'); // Asegúrate que database.php contenga:
require('fpdf/fpdf.php');

// Crear PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Función para conversión de caracteres
function texto($texto) {
    return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $texto);
}

// Encabezado
$pdf->Cell(0, 10, texto('Listado de Productos'), 0, 1, 'C');
$pdf->Ln(5);

// Configuración de tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 200, 200);
$pdf->Cell(10, 6, texto('ID'), 1, 0, 'C', true);
$pdf->Cell(30, 6, texto('Nombre'), 1, 0, 'C', true);
$pdf->Cell(80, 6, texto('Categoria'), 1, 0, 'C', true);
$pdf->Cell(60, 6, texto('Marca'), 1, 0, 'C', true);
$pdf->Cell(20, 6, texto('Artista'), 1, 0, 'C', true);
$pdf->Cell(60, 6, texto('Stock'), 1, 1, 'C', true);
$pdf->Cell(20, 6, texto('Descripcion'), 1, 1, 'C', true);

// Obtener datos (estilo procedural)
$query = "SELECT * FROM productos";
$result = mysqli_query($conexion, $query);

$pdf->SetFont('Arial', '', 10);
while($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(10, 6, texto($row['id']), 1, 0, 'C');
    $pdf->Cell(30, 6, texto($row['nombre']), 1, 0, 'C');
    $pdf->Cell(80, 6, texto(substr($row['categoria'], 0, 35)), 1, 0);
    $pdf->Cell(60, 6, texto(substr($row['marca'], 0, 30)), 1, 0);
    $pdf->Cell(20, 6, texto($row['artista']), 1, 0, 'C');
    $pdf->Cell(60, 6, texto(substr($row['stock'], 0, 20)), 1, 1);
    $pdf->Cell(20, 6, texto(substr($row['descripcion'], 0, 20)), 1, 1);
}

$pdf->Output('libros.pdf','I');
?>
