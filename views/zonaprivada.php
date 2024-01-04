<?php
require_once '../controllers/VideoclubController.php';
require '../controllers/LoginController.php';
//creo un objeto videoclubController
$videoclubController = new VideoclubController();
//recupero los datos del usuario de la sesion que debe se run objeto usuario
$_SESSION['usuario'];
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
    <header class="header_main header_short">
        <nav class="nav container" id="mininav">
            <h2 class="nav__logo">VideoClub <span class="char char--logo">O</span>mega</h2>

            <ul class="nav__links">

                <li class="nav__item">
                    <a href="../index.php" class="nav__link"><span class="char">I</span>nicio</a>
                </li>
                <li class="nav__item">
                    <a href="../pages/login.php" class="nav__link"><span class="char">A</span>cceso</a>
                </li>
                <li class="nav__item">
                    <a href="#" class="nav__link"><span class="char">S</span>ervicios</a>
                </li>
                <li class="nav__item">
                    <a href="../pages/asistencia.php" class="nav__link"><span class="char">A</span>sistencia</a>
                </li>

            </ul>

            <!--Tiene que ser un boton que haga referencia al id puesto en el nav-->
            <a href="#mininav" class="nav__hamburguer">
                <img src="./images/menu.svg" class="nav__icon">
            </a>

            <a href="" class="nav__close">
                <img src="./images/close.svg" class="nav__icon">
            </a>
        </nav>
    </header>
    <div class="visor visorindex">
        <!--creo un boton para hacer logout -->
        <form action="../controllers/LogoutController.php" method="post">
            <button type="submit" class="link">Cerrar sesión</button>
        </form>

        <div class="exito">
            <p class="text">Bienvenido usuario
                <?php
                //muestro el nombre del usuario del objeto usuario en mayusculas
                echo strtoupper($_SESSION['usuario']->getUsername());
                ?>
                . Estás es tu zona privada.</p>
        </div>
        <div class="panel">
            <h2 class="title">Listado de Películas</h2>
            <div class="peliculas-container">
                <?php
                $peliculasInfo = $videoclubController->listarPeliculasDetalladas();
                foreach ($peliculasInfo as $pelicula) : ?>
                    <div class="pelicula">
                        <img src="data:image/jpeg;base64,<?php echo $pelicula['pelicula_cartel']; ?>" alt="Cartel de la película">
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
                                        <img src="data:image/jpeg;base64,<?php echo $actor['actor_fotografia']; ?>" alt="Foto del actor">
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <!-- Si es administrador muestro botón de MODIFICAR y BORRAR -->
                            <?php
                            if ($_SESSION['usuario']->getRol() == 1) : ?>
                                <div class="borrar-button-container">
                                    <a href="../controllers/VideoclubController.php?action=borrarPelicula&idPelicula=<?php echo $pelicula['pelicula_id']; ?>" class="link">Borrar</a>
                                    <!-- Añadir el botón de Modificar aquí -->
                                    <a href="../controllers/VideoclubController.php?action=modificarPelicula&idPelicula=<?php echo $pelicula['pelicula_id']; ?>" class="link">Modificar</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>