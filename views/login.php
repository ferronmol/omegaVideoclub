<?php
require_once '../controllers/LoginController.php';
require_once '../models/UserModel.php';
// Verificar si hay un mensaje de éxito
if (isset($_GET['success'])) {
    $successMessage = urldecode($_GET['success']);
    echo '<p style="color: green;">' . htmlspecialchars($successMessage) . '</p>';
}
// Verificar si hay un mensaje de error
if (isset($_GET['error'])) {
    $errorMessage = urldecode($_GET['error']);
    echo '<p style="color: red;">' . htmlspecialchars($errorMessage) . '</p>';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entra en nuestro videoclub. Un mundo "de película" te espera.</title>
    <link rel="stylesheet" href="../views/css/styles.css">
    <link rel="shortcut icon" href="../views/images/estrella.png" type="image/x-icon">
</head>

<body>
    <div class="header">
        <h2>Iniciar sesión</h2>
    </div>
    <div class="visor visorlogin">
        <h2 class="consulta">Entra en nuestro videoclub. Un mundo "de película" te espera.</h2>

        <form class="form" action="login.php" method="post">
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
            <p class="text-white">Si no estás registrado <a class="link" href="register.php">Regístrate</a></p>
            <a href="../index.php" class="link">Volver a la página principal</a>
        </form>
    </div>

</body>

</html>