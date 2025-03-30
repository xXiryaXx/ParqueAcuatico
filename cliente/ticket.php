<?php
session_start();
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<h2>No hay productos en el carrito.</h2>";
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Ticket de Compra</title>
</head>
<body>
    <h2>Resumen de la Compra</h2>
    <table border="1">
        <tr>
            <th>Servicio</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($_SESSION['carrito'] as $item) : 
            $total += $item['subtotal']; ?>
        <tr>
            <td><?= $item['nombre'] ?></td>
            <td><?= $item['cantidad'] ?></td>
            <td>$<?= number_format($item['precio'], 2) ?></td>
            <td>$<?= number_format($item['subtotal'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Total</strong></td>
            <td><strong>$<?= number_format($total, 2) ?></strong></td>
        </tr>
    </table>
    <br>
    <form method="POST" action="procesar_compra.php">
        <button type="submit">Confirmar Compra</button>
    </form>
    <a href="carrito.php">Volver al carrito</a>
</body>
</html>
