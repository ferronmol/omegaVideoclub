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
    <title>Asistencia</title>
    <link rel="stylesheet" href="../views/css/styles.css">
    <link rel="shortcut icon" href="../views/images/estrella.png" type="image/x-icon">
</head>

<body>
    <div class="header">
        <h2>Asistencia Tecnica</h2>
    </div>
    <div class="visor visorasistencia">
        <h2 class="title">Rellene este formulario con su incidencia para poder ser atendido.</h2>
        <div class="form-container form-asis">
            <form id="consulta-form" class="form form-asis" name="asis-form" action="../controllers/AsisFormController.php" method="POST">

                <div class="consulta">

                    <label for="name" class="label">Nombre</label>
                    <input required type="text" id="name" name="name" class="form-input">
                </div>
                <div class="consulta">
                    <label for="email" class="label">Email</label>
                    <input required  type="text" id="email" name="email" class="form-input">

                </div>
                <div class="consulta">
                    <label for="tele" class="label">Teléfono</label>
                    <input required  type="tel" id="tele" name="tele" class="form-input">
                </div>
                <div class="consulta">
                    <label for="date" class="label">Fecha</label>
                    <input required type="date" id="date" name="date" class="form-input ">
                </div>
                <div class="consulta">
                    <label for="message" class="label">Motivo de la consulta</label>
                    <textarea  rows="5" required id="message" name="message" class="form-textarea" ></textarea>
                </div>
                <button type="submit" class="login-btn">Enviar Consulta</button>
            </form>
        </div>
        <!--boton para volver a la pagina principal -->
        <a class="link" href="zonaprivada.php">Volver a la página principal</a>
    </div>
</body>

</html>