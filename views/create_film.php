<?php
require_once '../controllers/VideoclubController.php';
require '../controllers/LoginController.php';
// Me aseguro  de que ya hay una sesión iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//creo un objeto videoclubController
$videoclubController = new VideoclubController();
//recupero los datos del usuario de la sesion que debe ser un objeto usuario
$_SESSION['usuario'];
if (isset($_GET['exito_creacion']) && $_GET['exito_creacion'] == 1) {
    $_SESSION['exito_creacion'] = '¡La película se creó con éxito!';
    //lo meto en una variable
    $exito_creacion = $_SESSION['exito_creacion'];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoclubOmega</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="shortcut icon" href="./images/estrella.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="visor visorindex">
        <div class="panel">
            <h2 class="title">Crear Pelicula </h2>
            <?php
                if (isset($exito_creacion)) : ?>
                    <div class="exito" role="alert">
                        <?php echo $exito_creacion; ?>
                    </div>
                <?php endif; ?>
            <div class="global-container">             
                <div class="form-container">
                    <!-- Formulario para crear la película -->
                    <form class="form" enctype="multipart/form-data" action="../controllers/VideoclubController.php?action=guardarCreacionPelicula" method="post">
                        <label class="label" for="titulo">Nuevo Título:</label>
                        <input class="form-input" type="text" id="titulo" required name="titulo"><br>

                        <label for="genero">Nuevo Género:</label>
                        <input class="form-input" type="text" id="genero" name="genero"><br>

                        <label for="pais">Nuevo País:</label>
                        <input class="form-input" type="text" id="pais" name="pais"><br>

                        <label for="anyo">Nuevo Año:</label>
                        <input class="form-input" type="text" id="anyo" name="anyo"><br>

                        <label for="cartel">Cartel de la película:</label>
                        <input class="form-input" type="file" name="cartel" id="cartel">

                        <button type="submit" class="login-btn">Guardar Pelicula</button>
                    </form>
                </div>
            </div>
            <div class="btn-container">
                <!--enlace para volver a la zona de administracion-->
                <a href="../views/zonaAdmin.php" class="link">Volver a administración</a>
                <!--creo un boton para hacer logout -->
                <form action="../controllers/LogoutController.php" method="post">
                    <button type="submit" class="link">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>