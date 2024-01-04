<?php
require_once '../models/UserModel.php';
//si no existe la sesion
if (session_status() == PHP_SESSION_NONE) {
    //la creo
    session_start();
}
class LoginController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel(new DB());
    }

    public function login($username, $password)
    {
        //obtener el usuario de la base de datos
        $usuario = $this->userModel->getUsuario($username);
        // Validar credenciales
        if ($this->userModel->verificarCredenciales($username, $password)) {

            //voy a almacenar un objeto usuario en la sesion

            $_SESSION['usuario'] = $usuario;
            //voy a depurar el objeto usuario
            var_dump($_SESSION['usuario']);

            // Credenciales correctas, si es usuario normal redirigir a la zona privada
            if ($_SESSION['usuario']->getRol() == 0) {
                header('Location: ../views/zonaprivada.php');
                exit;
            }
            // Credenciales correctas, si es administrador redirigir a la zona privada
            if ($_SESSION['usuario']->getRol() == 1) {
                header('Location: ../views/zonaAdmin.php');
                exit;
            }
        } else {
            // Credenciales incorrectas, redirigir con un mensaje de error

            // echo password_hash('1234', PASSWORD_DEFAULT);
            if ($usuario && password_verify($password, $usuario->getPassword())) {
                // Resto del código
            }

            $errorMessage = urlencode('Credenciales incorrectas');
            // header("Location: ../views/login.php?error=$errorMessage");
            // exit;
        }
    }
}
//crea una instancia de LoginController
$loginController = new LoginController();
//recibio un post de login_user
if (isset($_POST['login_user'])) {
    //recupero los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];
    //llamo al metodo login del controlador
    $loginController->login($username, $password);
}
