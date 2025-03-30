<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit();
}
include '../config/conexion.php';

$sql = "SELECT c.nombre, co.fecha_compra, co.total 
        FROM compras co
        JOIN clientes c ON co.id_cliente = c.id_cliente
        ORDER BY co.fecha_compra DESC";
$stmt = $conexion->query($sql);
$compras = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Dashboard - Administrador</title>
</head>
<body>
    <h2>Historial de Compras</h2>
    <table border="1">
        <tr>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
        </tr>
        <?php foreach ($compras as $compra) : ?>
        <tr>
            <td><?= $compra['nombre'] ?></td>
            <td><?= $compra['fecha_compra'] ?></td>
            <td>$<?= number_format($compra['total'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="../logout.php">Cerrar Sesión</a>
</body>
</html>
