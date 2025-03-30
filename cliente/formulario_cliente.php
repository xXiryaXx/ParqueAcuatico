<?php
include '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $codigo_compra = uniqid('CLI');

    $sql = "INSERT INTO clientes (nombre, email, telefono, codigo_compra) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    if ($stmt->execute([$nombre, $email, $telefono, $codigo_compra])) {
        echo "<script>alert('Registro exitoso. Tu código de compra es: $codigo_compra'); window.location.href = '../index.php';</script>";
    } else {
        echo "<script>alert('Error al registrar.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Registro de Cliente</title>
</head>
<body>
    <h2>Registrar Cliente</h2>
    <form method="POST" action="">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        
        <label>Email:</label>
        <input type="email" name="email" required>
        
        <label>Teléfono:</label>
        <input type="text" name="telefono">

        <button type="submit">Registrar</button>
    </form>
</body>
</html>
