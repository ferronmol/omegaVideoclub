<?php

require_once '../models/UserModel.php';  // Asegúrate de tener la ruta correcta

class LoginController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel(new DB());
    }

    public function login($username, $password)
    {
        // Validar credenciales
        if ($this->userModel->verificarCredenciales($username, $password)) {
            // Iniciar sesión
            session_start();
            $_SESSION['usuario'] = $username;

            // Redirigir a la zona privada
            header('Location: ../views/zonaprivada.php');
            exit;
        } else {
            // Credenciales incorrectas, redirigir con un mensaje de error
            $errorMessage = urlencode('Credenciales incorrectas');
            header("Location: ../views/login.php?error=$errorMessage");
            exit;
        }
    }
}
