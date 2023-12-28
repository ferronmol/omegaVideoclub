<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo '<h1>Archivo de acción</h1>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mostrar los datos en la consola
    echo '<script>';
    echo 'console.log("Datos recibidos en el archivo de acción:");';
    echo 'console.log("Username: ' . $username . '");';
    echo 'console.log("Password: ' . $password . '");';
    echo '</script>';
}

// Puedes agregar aquí la lógica adicional que necesites

// Redirigir a la página de registro
// header('Location: register.php');
// exit();
?>
