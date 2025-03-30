<?php
session_start();
include 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_servicio = $_POST['id_servicio'];
    $cantidad = $_POST['cantidad'];

    $sql = "SELECT * FROM servicios WHERE id_servicio = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id_servicio]);
    $servicio = $stmt->fetch();

    if ($servicio) {
        $item = [
            'id_servicio' => $servicio['id_servicio'],
            'nombre' => $servicio['nombre_servicio'],
            'precio' => $servicio['precio'],
            'cantidad' => $cantidad,
            'subtotal' => $servicio['precio'] * $cantidad
        ];

        $_SESSION['carrito'][] = $item;
    }

    header('Location: cliente/carrito.php');
}
?>
