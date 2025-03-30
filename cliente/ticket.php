<?php
session_start();
require('../libs/fpdf.php');
include '../config/conexion.php';

if (!isset($_GET['id_compra'])) {
    echo "<h2>No hay datos de compra para mostrar.</h2>";
    exit();
}

$id_compra = $_GET['id_compra'];

// Obtener datos de la compra
$sqlCompra = "SELECT c.id_compra, cl.nombre, c.total, c.fecha_compra 
              FROM compras c
              JOIN clientes cl ON c.id_cliente = cl.id_cliente
              WHERE c.id_compra = ?";
$stmtCompra = $conexion->prepare($sqlCompra);
$stmtCompra->execute([$id_compra]);
$compra = $stmtCompra->fetch();

// Obtener detalles de la compra
$sqlDetalles = "SELECT * FROM detalles_compra WHERE id_compra = ?";
$stmtDetalles = $conexion->prepare($sqlDetalles);
$stmtDetalles->execute([$id_compra]);
$detalles = $stmtDetalles->fetchAll();

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Encabezado del ticket
$pdf->Cell(190, 10, 'Parque Recreativo - Ticket de Compra', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, 'Fecha: ' . $compra['fecha_compra'], 0, 1, 'C');
$pdf->Ln(5);

// Información del cliente
$pdf->Cell(100, 10, 'Cliente: ' . $compra['nombre'], 0, 1);
$pdf->Cell(100, 10, 'ID Compra: ' . $compra['id_compra'], 0, 1);
$pdf->Ln(5);

// Encabezado de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Descripcion', 1);
$pdf->Cell(30, 10, 'Cantidad', 1);
$pdf->Cell(40, 10, 'Precio Unitario', 1);
$pdf->Cell(40, 10, 'Subtotal', 1);
$pdf->Ln();

// Detalles de la compra
$pdf->SetFont('Arial', '', 12);
foreach ($detalles as $detalle) {
    $subtotal = $detalle['cantidad'] * $detalle['precio_unitario'];
    $pdf->Cell(80, 10, utf8_decode($detalle['descripcion']), 1);
    $pdf->Cell(30, 10, $detalle['cantidad'], 1, 0, 'C');
    $pdf->Cell(40, 10, '$' . number_format($detalle['precio_unitario'], 2), 1, 0, 'C');
    $pdf->Cell(40, 10, '$' . number_format($subtotal, 2), 1, 0, 'C');
    $pdf->Ln();
}

// Total de la compra
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(150, 10, 'Total a Pagar', 1);
$pdf->Cell(40, 10, '$' . number_format($compra['total'], 2), 1, 0, 'C');

// Guardar el PDF y mostrarlo
$archivo = '../tickets/ticket_' . $id_compra . '.pdf';
$pdf->Output('F', $archivo);

// Redireccionar para descargar automáticamente
header('Location: ' . $archivo);
?>
