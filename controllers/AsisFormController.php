<?php
require '../models/Mailer.php';
require '../models/FormAsis.php';

use PHPMailer\PHPMailer\PHPMailer;
//creo una instancia de la clase PHPMailer
$mail = new PHPMailer();


class Controller {
    public function processForm() {
        // Verifica si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Captura los datos del formulario
            $name = $_POST['name_asis'];
            $email = $_POST['email_asis'];
            $tele = $_POST['tele_asis'];
            $date = $_POST['date_asis'];
            $message = $_POST['message_asis'];

            // Crea un objeto con los datos capturados
            $formData = new FormData($name, $email, $tele, $date, $message);

            // Aquí puedes hacer lo que quieras con el objeto formData, por ejemplo, enviar un correo electrónico
            $mailer = new Mailer();
            $mailer->sendEmail($formData);

            // Redirige a una página de confirmación u otra acción
            header('Location: index.php?action=confirmation');
            exit;
        }
    }
}
