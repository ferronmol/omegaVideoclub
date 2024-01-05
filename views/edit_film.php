<?php
require_once '../controllers/VideoclubController.php';
require '../controllers/LoginController.php';
// Me aseguro  de que ya hay una sesión iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//var_dump($_SESSION['usuario']);
// var_dump($_SESSION['exito_modificacion']);
//creo un objeto videoclubController
$videoclubController = new VideoclubController();
//recupero los datos del usuario de la sesion que debe se run objeto usuario
$_SESSION['usuario'];
//recupero el id de la pelicula que quiero modificar
$idPelicula = $_GET['idPelicula'];
//recupero los datos de la pelicula que quiero modificar
$pelicula = $videoclubController->actualizarPelicula($idPelicula);
if (isset($_GET['exito_modificacion']) && $_GET['exito_modificacion'] == 1) {
    $_SESSION['exito_modificacion'] = '¡La película se modificó con éxito!';
    //lo meto en una variable
    $exito_modificacion = $_SESSION['exito_modificacion'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoclubOmega</title>
    <link rel="stylesheet" href="./css/styleindex.css">
    <link rel="shortcut icon" href="./images/estrella.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="visor visorindex">
        <div class="panel">
            <h2 class="title">Editar Pelicula </h2>
            <?php
            if (isset($exito_modificacion)) : ?>
                <div class="exito" role="alert">
                    <?php echo $exito_modificacion; ?>
                </div>
            <?php endif; ?>
            <div class="global-container">

                <div class="peliculas-container">
                    <?php
                    $peliculasInfo = $videoclubController->actualizarPelicula($idPelicula);
                    foreach ($peliculasInfo as $pelicula) : ?>
                        <div class="pelicula">
                            <div class="img-container">
                                <img class="img-peli" src="<?php echo $pelicula['pelicula_cartel']; ?>" alt="Cartel de la película">
                            </div>
                            <div class="detalle-pelicula">
                                <h3><?php echo $pelicula['pelicula_titulo']; ?></h3>
                                <p>Género: <?php echo $pelicula['pelicula_genero']; ?></p>
                                <p>País: <?php echo $pelicula['pelicula_pais']; ?></p>
                                <p>Año: <?php echo $pelicula['pelicula_anyo']; ?></p>
                                <h4>Actores:</h4>
                                <ul>
                                    <?php foreach ($pelicula['actores'] as $actor) : ?>
                                        <li>
                                            <strong>Nombre:</strong> <?php echo $actor['actor_nombre']; ?><br>
                                            <strong>Apellidos:</strong> <?php echo $actor['actor_apellidos']; ?><br>
                                            <img src="<?php echo $actor['actor_fotografia']; ?>" alt="Foto del actor">
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <!-- Si es administrador muestro botón de MODIFICAR y BORRAR -->
                                <?php
                                if ($_SESSION['usuario']->getRol() == 1) : ?>
                                    <div class="borrar-button-container">
                                        <a href="../controllers/VideoclubController.php?action=borrarPelicula&idPelicula=<?php echo $pelicula['pelicula_id']; ?>" class="link">Borrar</a>
                                    <?php endif; ?>
                                    </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <div class="form-container">
                    <!--------------------- Formulario para modificar la película ----------------------------->
                    <form class="form" enctype="multipart/form-data" action="../controllers/VideoclubController.php?action=guardarModificacionPelicula&idPelicula=<?php echo $pelicula['pelicula_id']; ?>" method="post">
                        <label class="label" for="titulo">Nuevo Título:</label>
                        <input class="form-input" type="text" id="titulo" name="titulo" value="<?php echo $pelicula['pelicula_titulo']; ?>"><br>

                        <label for="genero">Nuevo Género:</label>
                        <input class="form-input" type="text" id="genero" name="genero" value="<?php echo $pelicula['pelicula_genero']; ?>"><br>

                        <label for="pais">Nuevo País:</label>
                        <input class="form-input" type="text" id="pais" name="pais" value="<?php echo $pelicula['pelicula_pais']; ?>"><br>

                        <label for="anyo">Nuevo Año:</label>
                        <input class="form-input" type="text" id="anyo" name="anyo" value="<?php echo $pelicula['pelicula_anyo']; ?>"><br>

                        <label for="cartel">Cartel de la película:</label>
                        <input class="form-input" type="file" name="cartel" id="cartel">

                        <button type="submit" class="login-btn">Guardar Cambios</button>
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
</body>

</html>