<?php
require_once '../controllers/VideoclubController.php';
require '../controllers/LoginController.php';
//creo un objeto videoclubController
$videoclubController = new VideoclubController();
//recupero los datos del usuario de la sesion que debe se run objeto usuario
$_SESSION['usuario'];
if (isset($_GET['exito_borrado']) && $_GET['exito_borrado'] == 1) {
    $_SESSION['exito_borrado'] = '¡La película se borró éxito!';
    //lo meto en una variable
    $exito_borrado = $_SESSION['exito_borrado'];
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
    <header class="header_main header_short">
        <nav class="nav mininav" id="mininav">
            <h2 class="nav__logo">VideoClub <span class="char char--logo">O</span>mega</h2>

            <ul class="nav__links">

                <li class="nav__item">
                    <a href="../index.php" class="nav__link"><span class="char">I</span>nicio</a>
                </li>
                <li class="nav__item">
                    <a href="../views/login.php" class="nav__link"><span class="char">A</span>cceso</a>
                </li>
                <li class="nav__item">
                    <a href="#" class="nav__link"><span class="char">S</span>ervicios</a>
                </li>
                <li class="nav__item">
                    <a href="#" class="nav__link"><span class="char">C</span>ontacto</a>
                </li>

            </ul>

            <!--Tiene que ser un boton que haga referencia al id puesto en el nav-->
            <a href="#mininav" class="nav__hamburguer">
                <img src="./images/menu.svg" class="nav__icon" alt="menu icon">
            </a>

            <a href="" class="nav__close">
                <img src="./images/close.svg" class="nav__icon" alt="menu icon">
            </a>
        </nav>
    </header>
    <div class="visor visorindex">
        <!--creo un boton para hacer logout -->
        <form action="../controllers/LogoutController.php" method="post">
            <button type="submit" class="link">Cerrar sesión</button>
        </form>
        <div class="exito">Bienvenido Administrador
            <?php
            //muestro el nombre del usuario del objeto usuario en mayusculas
            echo strtoupper($_SESSION['usuario']->getUsername());
            ?>
            . Estas es tu zona privada.
        </div>
        <div class="panel">
            <!--muestro mi exito de boorado si existe-->
            <?php
            if (isset($exito_borrado)) : ?>
                <div class="exito" role="alert">
                    <?php echo $exito_borrado; ?>
                </div>
            <?php endif; ?>
            <h2 class="title">Listado de Películas</h2>
            <!-- Botón para insertar una nueva película -->
            <div class="button-container">
                <a href="../controllers/VideoclubController.php?action=crearPelicula" class="link">Insertar Película</a>
            </div>

            <div class="peliculas-container">
                <?php
                $peliculasInfo = $videoclubController->listarPeliculasDetalladas();
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
                                        <div class="img-container">
                                            <img class="img-actor" src="<?php echo $actor['actor_fotografia']; ?>" alt="Foto del actor">
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <!-- Si es administrador muestro botón de MODIFICAR y BORRAR -->
                            <?php
                            if ($_SESSION['usuario']->getRol() == 1) : ?>
                                <div class="button-container">
                                    <a href="../controllers/VideoclubController.php?action=modificarPelicula&idPelicula=<?php echo $pelicula['pelicula_id']; ?>" class="link">Modificar</a>
                                    <a href="../controllers/VideoclubController.php?action=borrarPelicula&idPelicula=<?php echo $pelicula['pelicula_id']; ?>" class="link">Borrar</a>
                                <?php endif; ?>
                                </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="#mininav" class="link">Volver arriba</a>
        </div>
    </div>
</body>
</html>