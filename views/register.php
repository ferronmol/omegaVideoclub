<!--  Vista para el registro de usuarios -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Registro</title>
    <link rel="stylesheet" href="../views/css/styleindex.css">
    <link rel="shortcut icon" href="../views/images/estrella.png" type="image/x-icon">
</head>

<body>

    <div class="header">
        <h2>Registro</h2>
    </div>
    <div class="visor visorregister">
        <form class="form" action="../controllers/RegisterController.php" method="post">
            <?php
            // Mostrar errores si los hay
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<div class='error'><h3>$error</h3></div>";
                }
            } 
            ?>
            <div class="input-group">
                <label class="label" for="username">Nombre de Usuario</label>
                <input type="text" required name="username" class="form-input" autocomplete="username">
            </div>
            <div class="input-group">
                <label class="label" for="password">Contraseña</label>
                <input type="password" required name="password" class="form-input" autocomplete="current-password">
            </div>
            <div class="input-group">
                <button type="submit" name="reg_user" class="login-btn">Registrarse</button>
            </div>
            <p>Si ya estás registrado <a href="login.php" class="link">Iniciar Sesión</a></p>
        </form>
    </div>
</body>

</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo '<div style="margin-top: 20px; background-color: #f0f0f0; padding: 10px;">';
    echo '<h3>Datos Enviados:</h3>';
    echo '<p>Nombre de Usuario: ' . htmlspecialchars($_POST['username']) . '</p>';
    echo '<p>Contraseña: ' . htmlspecialchars($_POST['password']) . '</p>';
    echo '</div>';
}
?>

