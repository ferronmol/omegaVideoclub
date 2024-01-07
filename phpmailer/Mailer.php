<?php
require '../config/config.php';
require_once 'PHPMailer.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    public function sendEmail($formData) {
        // Crea una nueva instancia de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor de correo que utilizará PHPMailer cogiendo los datos de config.php
            $mail->isSMTP();
            $mail->Host = $GLOBALS['smtpHost'];
            $mail->SMTPAuth = true;
            $mail->Username = $GLOBALS['smtpUsername'];
            $mail->Password = $GLOBALS['smtpPassword'];
            $mail->SMTPSecure = $GLOBALS['smtpEncryption'];
            $mail->Port = $GLOBALS['smtpPort'];

            // Configuración del correo electrónico
            $mail->setFrom($formData->email, $formData->name);
            $mail->addAddress($GLOBALS['adminEmail']);  // Coloca la dirección del destinatario aquí
            $mail->Subject = 'Consulta de Asistencia de ' . $formData->name . '';
            $mail->Body = $formData->message;

            //$mail->SMTPDebug = 2; // Activa la salida de depuración detallada(si no funciona el envio)

            // Enviar el correo electrónico
            $mail->send();

            echo 'Correo electrónico enviado con éxito';
        } catch (Exception $e) {
            echo 'Error al enviar el correo electrónico: ', $mail->ErrorInfo;
        }
    }
}
