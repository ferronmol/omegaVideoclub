<?php
require_once __DIR__ . '/../phpmailer/PHPMailer.php';
require_once __DIR__ . '/../phpmailer/Exception.php';
require_once __DIR__ . '/../phpmailer/SMTP.php';
require_once '../models/AsisModel.php';
require __DIR__ . '/../phpmailer/Mailer.php';
require_once '../config/config.php';
require_once 'LogController.php';
//si no existe la sesion
if (session_status() == PHP_SESSION_NONE) {
    //la creo
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AsisFormController
{
    public function procesarForm()
    {
        // Verifica si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Captura los datos del formulario
            $name = $_POST['name'];
            $email = $_POST['email'];
            $tele = $_POST['tele'];
            $date = $_POST['date'];
            $message = $_POST['message'];

            // Crea un objeto de la clase formData con los datos capturados
            $formData = new FormData($name, $email, $tele, $date, $message);

            var_dump($formData);

            // lo envio un correo electrónico
            $mail = new PHPMailer();
            $mailer = new Mailer();
            try {
                $mailer->sendEmail($formData);
                // Verifico si la sesión está iniciada y las variables de sesión están definidas
                if (isset($_SESSION['username']) && isset($_SESSION['rol'])) {
                // Las variables de sesión están disponibles, las uso
                $username = $_SESSION['username'];
                $rol = $_SESSION['rol'];
                //lo guardo en el log
                $logController = new LogController();
                $_SESSION['message'] = 'Consulta enviada con éxito';
               
                //llamo al metodo logAccess para escribir en el log
                $logController->logMail($formData, $username, $rol);
                }
                else {
                    // Las variables de sesión no están disponibles, las obtengo de la cookie
                    if (isset($_COOKIE['username']) && isset($_COOKIE['rol'])) {
                    $username = $_COOKIE['username'];
                    $rol = $_COOKIE['rol'];
                    //lo guardo en el log
                    $logController = new LogController();
                    $_SESSION['message'] = 'Consulta enviada con éxito';
                    //llamo al metodo logAccess para escribir en el log
                    $logController->logMail($formData, $_COOKIE['username'], $_COOKIE['rol']);
                    }
                    else {
                        $username = 'Anónimo';
                        $rol = 'Anónimo';
                        //lo guardo en el log
                        $logController = new LogController();
                        $_SESSION['message'] = 'Consulta enviada con éxito';
                        //llamo al metodo logAccess para escribir en el log
                        $logController->logMail($formData, $username, $rol);
                    }
                }
                // Redirigir a la página con éxito
                header('Location: ../views/asistencia.php?success=' . urlencode('Consulta enviada con éxito'));
            } catch (Exception $e) {
                //mandar a la pagina con error
                header('Location: ../views/asistencia.php?error=' . urlencode('Error al enviar el correo'));
            }
        }
    }
}
//llamamos a la clase que envía el correo
$asisFormController = new AsisFormController();
//llamamos a la función para procesar el formulario
$asisFormController->procesarForm();
