<?php

require 'controllers/LoginController.php';
//crea unainstancia de LoginController
$loginController = new LoginController();


// Verificar si el usuario está logueado y redirigir según sea necesario
if (isset($_SESSION['usuario'])) {
    if (isset($_GET['controller']) && $_GET['controller'] === 'Videoclub') {
        // Si está intentando acceder a Videoclub y ya está logueado, redirige a zonaprivada
        header('Location: /views/zonaprivada.php');
        exit;
    } else {
        // Si está intentando acceder a cualquier otra página y ya está logueado, redirige a index.php
        header('Location: /index.php');
        exit;
    }
} elseif (isset($_GET['controller']) && $_GET['controller'] === 'Videoclub') {
    // Si no está logueado, redirige a la página de inicio de sesión
    header('Location: /views/login.php');
    exit;
}

// Procesar el formulario de inicio de sesión
if (isset($_POST['login_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Llamamos al método de LoginController para procesar el inicio de sesión
    $loginController->login($username, $password);
}


?>
