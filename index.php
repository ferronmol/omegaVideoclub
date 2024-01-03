
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoclubOmega</title>
    <link rel="stylesheet" href="./views/css/styleindex.css">
    <link rel="shortcut icon" href="./views/images/estrella.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>
<body>
    <header class="header_main header_short">
        <nav class="nav container" id="mininav">
            <h2 class="nav__logo">VideoClub <span class="char char--logo">O</span>mega</h2>

            <ul class="nav__links">

                <li class="nav__item">
                    <a href="index.php" class="nav__link"><span class="char">I</span>nicio</a>
                </li>
                <li class="nav__item">
                    <a href="views/login.php" class="nav__link"><span class="char">A</span>cceso</a>
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
                <img src="./views/images/menu.svg" class="nav__icon">
            </a>

            <a href="" class="nav__close">
                <img src="./views/images/close.svg" class="nav__icon">
            </a>
        </nav>
    </header>
    <div class="visor visorindex">
    </div>
    
    
</body>

</html>