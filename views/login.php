<?php
require_once '../frontcontroller.php';


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

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entra en nuestro videoclub. Un mundo "de película" te espera.</title>
    <link rel="stylesheet" href="../views/css/styleindex.css">
    <link rel="shortcut icon" href="../views/images/estrella.png" type="image/x-icon">
</head>

<body>
    <div class="header">
        <h2>Iniciar sesión</h2>
    </div>
    <div class="visor visorlogin">
        <h2 class="consulta">Entra en nuestro videoclub. Un mundo "de película" te espera.</h2>

        <form class="form" action="login.php" method="post">
            <?php
            // Verificar si hay errores antes de mostrar el div
            if (isset($_GET['errorNotFound'])) {
            ?>
                <div class="error">
                    <h3>El usuario no se encuentra registrado</h3>
                </div>
            <?php } //fin del error de un usuario no encontrado
            if (isset($_GET['errorNotMatch'])) {
            ?>
                <div class="error">
                    <h3>Usuario y/o contraseña no válidas</h3>
                </div>
            <?php } //Fin del error de credenciales no válidas
            ?>
            <div class="input-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" required name="username">
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" required name="password">
            </div>
            <div class="">
                <button type="submit" name="login_user" class="login-btn">Iniciar sesión</button>

            </div>
            <p>Si no estás registrado <a class="link" href="register.php">Regístrate</a></p>
            <a href="../index.php" class="link">Volver a la página principal</a>
        </form>
    </div>

</body>

</html>