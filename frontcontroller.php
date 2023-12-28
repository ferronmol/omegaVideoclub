<?php

// Verificar si el usuario está logueado y redirigir según sea necesario
if (isset($_SESSION['usuario'])) {
    if (isset($_GET['controller']) && $_GET['controller'] === 'Videoclub') {
        // Si está intentando acceder a Videoclub y ya está logueado, redirige a zonaprivada
        header('Location: /views/zonaprivada.php');
        exit;
    } else {
        // Redirige a la página de inicio de la aplicación
        // Puedes cambiar la URL según la estructura de tu proyecto
        header('Location: /index.php');
        exit;
    }
} else if (isset($_GET['controller']) && $_GET['controller'] === 'Videoclub') {
    // Si no está logueado, redirige a la página de inicio de sesión
    header('Location: /views/login.php');
    exit;
}
//procesar el formulario
if (isset($_POST['login_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginController->login($username, $password);
} 

?>