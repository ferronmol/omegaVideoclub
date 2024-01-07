<?php
require_once '../models/UserModel.php';
require_once 'LogController.php';
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
    public function index()
    {
        // Muestro siempre el HTML del login con el formulario
        require_once '../views/login.php';
    }

    public function login($username, $password)
    { // Creamos la instancia de UserModel cuando el usuario hace login
        //  if (!$this->userModel) {
        //      $this->userModel = new UserModel(new DB());
        // }
        //obtener el usuario de la base de datos
        $usuario = $this->userModel->getUsuario($username);
        // Validar credenciales
        if ($this->userModel->verificarCredenciales($username, $password)) {

            //voy a almacenar un objeto usuario en la sesion

            $_SESSION['usuario'] = $usuario;
            //voy a depurar el objeto usuario
            var_dump($_SESSION['usuario']);

            // Credenciales correctas, si es usuario normal redirigir a la zona privada
            //lo guardo en e log como acceso a la zona privada , creo instancia de logController
            $logController = new LogController();
            //llamo al metodo logAccess para escribir en el log
            $logController->logAccess($username, $usuario->getRol());

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
            // Credenciales incorrectas, guardar en el log
            $logController = new LogController();
            //llamo a la funcion logFailedAccess
            $logController->logFailedAccess($username, $password, $usuario->getRol());

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

