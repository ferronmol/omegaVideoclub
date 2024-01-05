<?php
require_once '../models/UserModel.php';
require 'LogController.php';
session_start();


class LogoutController
{
    public function __construct()
    {
        // Si está definida la clase usuario en la sesión
        if (isset($_SESSION['usuario'])) {
            $username = $_SESSION['usuario']->getUsername();
            $rol = $_SESSION['usuario']->getRol();

            // Creo un objeto LogController
            $logController = new LogController();
            
            // Llamo al método logOut para escribir en el log
            $logController->logOut($username, $rol);

            // Llamo al método logout para destruir la sesión y redirigir al index
            $this->logout();
        } else {
            // Si no está definida la clase usuario en la sesión, redirijo al index
            header('Location: ../index.php');
            exit();
        }
    }

    private function logout()
    {
        // Destruyo la sesión
        session_unset();
        session_destroy();
        
        // Redirijo al index después de destruir la sesión
        header('Location: ../index.php');
        exit();
    }
}

// Creo una instancia de LogoutController
$logoutController = new LogoutController();
?>
