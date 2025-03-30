<?php
session_start();
include '../config/conexion.php';

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
                <button type="submit">Agregar al Carrito</button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>

    <br>
    <a href="ticket.php">Ver Ticket</a>
</body>
</html>
