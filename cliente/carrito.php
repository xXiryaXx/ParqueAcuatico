<?php
session_start();
include '../config/conexion.php';

// Consulta de servicios disponibles
$sql = "SELECT * FROM servicios";
$stmt = $conexion->query($sql);
$servicios = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Carrito de Compras</title>
</head>
<body>
    <h2>Servicios Disponibles</h2>
    <div class="container">
        <?php foreach ($servicios as $servicio) : ?>
        <div class="card">
            <img src="../img/<?= strtolower(str_replace(' ', '_', $servicio['nombre_servicio'])) ?>.jpg" alt="<?= $servicio['nombre_servicio'] ?>">
            <h3><?= $servicio['nombre_servicio'] ?></h3>
            <p><?= $servicio['descripcion'] ?></p>
            <p><strong>$<?= number_format($servicio['precio'], 2) ?></strong></p>
            <form method="POST" action="../carrito_procesar.php">
                <input type="hidden" name="id_servicio" value="<?= $servicio['id_servicio'] ?>">
                <label>Cantidad:</label>
                <input type="number" name="cantidad" min="1" value="1" required>
                <button type="submit">Agregar al Carrito 🛒</button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>

    <br><br>
    <h2>🛒 Carrito de Compras</h2>

    <?php if (!empty($_SESSION['carrito'])) : ?>
    <table>
        <tr>
            <th>Servicio</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
            <th>Acciones</th>
        </tr>
        <?php
        $total = 0;
        foreach ($_SESSION['carrito'] as $key => $item) :
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= $item['nombre'] ?></td>
            <td><?= $item['cantidad'] ?></td>
            <td>$<?= number_format($item['precio'], 2) ?></td>
            <td>$<?= number_format($subtotal, 2) ?></td>
            <td>
                <a href="../eliminar_item.php?key=<?= $key ?>" onclick="return confirm('¿Eliminar este servicio del carrito?');">
                    ❌ Eliminar
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Total a Pagar</strong></td>
            <td><strong>$<?= number_format($total, 2) ?></strong></td>
            <td></td>
        </tr>
    </table>

    <form method="POST" action="procesar_compra.php">
        <button type="submit">🧾 Confirmar Compra</button>
    </form>

    <?php else : ?>
        <p>No hay productos en el carrito. 🛒</p>
    <?php endif; ?>

    <br>
    <a href="../logout.php">Cerrar Sesión 🚪</a>
</body>
</html>
