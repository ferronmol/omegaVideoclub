require 'vendor/autoload.php'; // Asegúrate de incluir el archivo de la librería PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    public function sendEmail(FormAsis $formData) {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor de correo
            $mail->isSMTP();
            $mail->Host = 'tu_servidor_smtp.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tu_usuario_smtp';
            $mail->Password = 'tu_contraseña_smtp';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Configuración del correo electrónico
            $mail->setFrom($formData->email, $formData->name);
            $mail->addAddress('destinatario@example.com');
            $mail->Subject = 'Consulta del Formulario';
            $mail->Body = $formData->message;

            // Enviar el correo electrónico
            $mail->send();

            echo 'Correo electrónico enviado con éxito';
        } catch (Exception $e) {
            echo 'Error al enviar el correo electrónico: ', $mail->ErrorInfo;
        }
    }
}
