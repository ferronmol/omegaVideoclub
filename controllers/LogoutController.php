<?php
session_start();
function micargador($class)
{
    include '../models/' . $class . '.php'; 
}

spl_autoload_register('micargador');

class LogoutController
{

    public function __construct()
    {
        //si esta definada la clase usuario en la sesion
        if (isset($_SESSION['usuario'])) {
            //llamo al metodo logout
            echo "esra definida la clase usuario en la sesion";
            $this->logout();
        } else {
            //si no esta definida la clase usuario en la sesion
            echo "No esat definida la clase usuario en la sesion";
        }
        $username = isset($_SESSION['usuario']) ? $_SESSION['usuario']->getUsername() : 'Desconocido';
        $this->logAccess($username);
        $this->logout();
        //redirijo a la pagina de index
        header('Location: ../index.php');
      
    }



    private function logAccess($username)
    {
        $logFile = '../logs/log.txt';



        // Obtener la fecha y hora actual
        $date = date('Y-m-d H:i:s');

        // Formato de registro: [Fecha y hora] - Usuario: [nombre de usuario] - Acción: Cierre de sesión
        $logMessage = "[" . $date . "] - Usuario: " . $username . " - Acción: Cierre de sesión" . PHP_EOL;

        //escribir en el archivo
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
        echo "Se ha cerrado la sesión.Log registrado en $logFile";
    }

    private function logout()
    {
        // destruyo la sesion
        session_unset();
        session_destroy();
      
    }
}
$logoutController = new LogoutController();
