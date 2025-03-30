<?php
session_start();
include '../config/conexion.php';

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<script>alert('No hay productos para procesar.'); window.location.href='carrito.php';</script>";
    exit();
}

$codigo_compra = $_SESSION['codigo_compra'];
$sqlCliente = "SELECT id_cliente FROM clientes WHERE codigo_compra = ?";
$stmtCliente = $conexion->prepare($sqlCliente);
$stmtCliente->execute([$codigo_compra]);
$cliente = $stmtCliente->fetch();

if ($cliente) {
    $id_cliente = $cliente['id_cliente'];
    $total = array_sum(array_column($_SESSION['carrito'], 'subtotal'));

    $sqlCompra = "INSERT INTO compras (id_cliente, total) VALUES (?, ?)";
    $stmtCompra = $conexion->prepare($sqlCompra);
    $stmtCompra->execute([$id_cliente, $total]);

    $id_compra = $conexion->lastInsertId();

    foreach ($_SESSION['carrito'] as $item) {
        $sqlDetalle = "INSERT INTO detalles_compra (id_compra, descripcion, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
        $stmtDetalle = $conexion->prepare($sqlDetalle);
        $stmtDetalle->execute([$id_compra, $item['nombre'], $item['cantidad'], $item['precio']]);
    }

    unset($_SESSION['carrito']);
    echo "<script>alert('Compra realizada con éxito.'); window.location.href='ticket.php';</script>";
} else {
    echo "<script>alert('Error en el proceso de compra.');</script>";
}
?>
