<?php
require_once '../controllers/VideoclubController.php';
require '../controllers/LoginController.php';
session_start();
//recupero los datos del usuario de la sesion que debe se run objeto usuario
var_dump($_SESSION['usuario']);
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
                    <a href="#" class="nav__link"><span class="char">C</span>ontacto</a>
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
        <a href="../controllers/Logout.php" class="btn btn-success">Logout</a>
    <div class="exito">Bienvenido Administrador
         <?php
          //muestro los datos del usuario que esta en la sesion
        //   echo $_SESSION['usuario'];
          ?>
     . Estas es tu zona privada.
    </div>  
     <!-- Llamada a la acción para mostrar películas -->
     <?php
    $videoclubController = new VideoclubController();
    // $videoclubController->listarPeliculas();
    ?>
    
    </div>
</body>


</html>