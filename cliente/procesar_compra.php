<?php
session_start();
include '../config/conexion.php';

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<script>alert('No hay productos para procesar.'); window.location.href='carrito.php';</script>";
    exit();
}

// Simulando ID de cliente (Esto debería obtenerse del cliente autenticado)
$id_cliente = $_SESSION['id_cliente'] ?? 1;
$total = array_sum(array_column($_SESSION['carrito'], 'subtotal'));

// Insertar compra
$sqlCompra = "INSERT INTO compras (id_cliente, total) VALUES (?, ?)";
$stmtCompra = $conexion->prepare($sqlCompra);
$stmtCompra->execute([$id_cliente, $total]);

$id_compra = $conexion->lastInsertId();

// Insertar detalles de la compra
foreach ($_SESSION['carrito'] as $item) {
    $sqlDetalle = "INSERT INTO detalles_compra (id_compra, descripcion, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
    $stmtDetalle = $conexion->prepare($sqlDetalle);
    $stmtDetalle->execute([$id_compra, $item['nombre'], $item['cantidad'], $item['precio']]);
}

// Limpiar carrito después de compra
unset($_SESSION['carrito']);
echo "<script>alert('Compra realizada con éxito. 🎉'); window.location.href='ticket.php?id_compra=$id_compra';</script>";
?>
