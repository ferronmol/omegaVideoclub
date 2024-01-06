
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
        $date = $formData->getDate();
        $message = $formData->getMessage();

        $logMessage = "[" . $date . "] - Usuario: " . $username . " - Rol: " .$rol . " - Acción: Envio de correo 
        de $name mail $email, tel $tele , en fecha $date y mensaje: $message " . PHP_EOL;


        //escribir en el archivo
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);

        echo "Se ha enviado el correo.Log registrado en $logFile";

    }
}
