<?php
require('database.php'); 
require('fpdf/fpdf.php');

// CREAR DOCUMENTO PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// CONFIGURACION DE CARACTERES ESPECIALES
function texto($texto) {
    return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $texto);
}

// ENCABEZADO DEL DOCUMENTO
$pdf->Cell(0, 10, texto('Listado de Productos'), 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(200, 200, 200);
$pdf->Cell(10, 6, texto('ID'), 1, 0, 'C', true);       
$pdf->Cell(35, 6, texto('Nombre'), 1, 0, 'C', true);   
$pdf->Cell(20, 6, texto('Categoria'), 1, 0, 'C', true); 
$pdf->Cell(20, 6, texto('Marca'), 1, 0, 'C', true);     
$pdf->Cell(15, 6, texto('Artista'), 1, 0, 'C', true);   
$pdf->Cell(18, 6, texto('Stock'), 1, 0, 'C', true);    
$pdf->Cell(70, 6, texto('Descripcion'), 1, 1, 'C', true); 

// ACTIVAR LA TABLA INVENTARIO
$query = "SELECT * FROM inventario";
$result = mysqli_query($conexion, $query);

$pdf->SetFont('Arial', '', 10);
while($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(10, 6, texto($row['id']), 1, 0, 'C');         
    $pdf->Cell(35, 6, texto($row['nombre']), 1, 0, 'C');     
    $pdf->Cell(20, 6, texto(substr($row['categoria'], 0, 25)), 1, 0); 
    $pdf->Cell(20, 6, texto(substr($row['marca'], 0, 20)), 1, 0);     
    $pdf->Cell(15, 6, texto($row['artista']), 1, 0, 'C');     
    $pdf->Cell(18, 6, texto($row['stock']), 1, 0, 'C');     
    $pdf->Cell(70, 6, texto(substr($row['descripcion'], 0, 60)), 1, 1); 
}

$pdf->Output('inventario.pdf', 'I'); 
?>