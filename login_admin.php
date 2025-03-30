<?php
session_start();
include 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM administradores WHERE usuario = ? AND password = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$usuario, $password]);
    $admin = $stmt->fetch();

    if ($admin) {
        $_SESSION['admin'] = $admin['usuario'];
        header('Location: admin/dashboard.php');
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/estilos.css">
    <title>Login Administrador</title>
</head>
<body>
    <h2>Login Administrador</h2>
    <form method="POST" action="">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>
        
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
