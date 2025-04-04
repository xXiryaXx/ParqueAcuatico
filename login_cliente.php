<?php
session_start();
include 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo_compra = $_POST['codigo_compra'];

    $sql = "SELECT * FROM clientes WHERE codigo_compra = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$codigo_compra]);
    $cliente = $stmt->fetch();

    if ($cliente) {
        $_SESSION['cliente'] = $cliente['nombre'];
        $_SESSION['codigo_compra'] = $cliente['codigo_compra'];
        header('Location: cliente/ticket.php');
    } else {
        echo "<script>alert('Código de compra incorrecto.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/estilos.css">
    <title>Login Cliente</title>
</head>
<body>
    <h2>Login Cliente</h2>
    <form method="POST" action="">
        <label>Código de Compra:</label>
        <input type="text" name="codigo_compra" required>
        
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
