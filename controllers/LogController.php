
<!--me creo mi clase LogController -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class LogController
{
    public function logOut($username, $rol)
    {
        $logFile = '../logs/log.txt';

        // Obtener la fecha y hora actual
        $date = date('Y-m-d H:i:s');

        // Formato de registro: [Fecha y hora] - Usuario: [nombre de usuario] - Acción: Cierre de sesión
        $logMessage = "[" . $date . "] - Usuario: " . $username . " - Rol: " .$rol . " - Acción: Cierre de sesión" . PHP_EOL;

        //escribir en el archivo
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
        echo "Se ha cerrado la sesión.Log registrado en $logFile";
    }
    
    public function logAccess($username, $rol)
    {
        $logFile = '../logs/log.txt';

        // Obtener la fecha y hora actual
        $date = date('Y-m-d H:i:s');

        $logMessage = "[" . $date . "] - Usuario: " . $username . " - Rol: " .$rol . " - Acción: Acceso a la zona privada" . PHP_EOL;

        //escribir en el archivo
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
        echo "Se ha accedido a la zona privada.Log registrado en $logFile";
    }
    public function logMail(FormData $formData , $username, $rol){
        $logFile = '../logs/log.txt';

        // Obtener la fecha y hora actual
        $date = date('Y-m-d H:i:s');

        //Extraigo del objeto los datos que me interesan
        $name = $formData->getName();
        $email = $formData->getEmail();
        $tele = $formData->getTele();
        $dates = $formData->getDate();
        $message = $formData->getMessage();

        $logMessage = "[" . $date . "] - Usuario: " . $username . " - Rol: " .$rol . " - Acción: Envio de correo 
        de $name mail $email, tel $tele , en fecha $dates y mensaje: $message " . PHP_EOL;


        //escribir en el archivo
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);

        echo "Se ha enviado el correo.Log registrado en $logFile";

    }

    //funcion para registrar intentos de acceso fallidos
    public function logFailedAccess($username, $password, $rol)
    {
        $logFile = '../logs/log.txt';

        // Obtener la fecha y hora actual
        $date = date('Y-m-d H:i:s');

        $logMessage = "[" . $date . "] - Usuario: " . $username . " - Rol: " .$rol . " - Acción: Acceso fallido a la zona privada" . PHP_EOL;

        //escribir en el archivo
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
        //mando un mensaje de error al login
        header('location: ../views/login.php?error=' . urlencode("Usuario o contraseña incorrectos"));
    }
    //funcion para registrar qeu el admin ha borrado, insertado o modificado una pelicula
    public function logAdminAction($username, $rol, $accion)
    {
        $logFile = '../logs/log.txt';

        // Obtener la fecha y hora actual
        $date = date('Y-m-d H:i:s');

        $logMessage = "[" . $date . "] - Usuario: " . $username . " - Rol: " .$rol . " - Acción: " . $accion . PHP_EOL;
         
        //escribir en el archivo
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
        echo "Se ha registrado la acción del administrador";
    }

    //funcion para registrar la creacion de un usuario
    public function logUserCreation($username, $rol)
    {
        $logFile = '../logs/log.txt';

        // Obtener la fecha y hora actual
        $date = date('Y-m-d H:i:s');

        $logMessage = "[" . $date . "] - Usuario: " . $username . " - Rol: " .$rol . " - Acción: Se ha registrado un usuario" . PHP_EOL;

        //escribir en el archivo
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
        echo "Se ha registrado la creación de un usuario";
    }
}
