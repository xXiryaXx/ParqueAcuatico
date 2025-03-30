<?php
session_start();

if (isset($_GET['key'])) {
    $key = $_GET['key'];

    if (isset($_SESSION['carrito'][$key])) {
        unset($_SESSION['carrito'][$key]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reorganizar el array
    }
}

header('Location: cliente/carrito.php');
?>
