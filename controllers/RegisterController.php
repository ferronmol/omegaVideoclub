<?php
require_once '../db/DB.php';
require_once '../models/UserModel.php';
require_once '../controllers/LogController.php';
class RegisterController
{
    private $userModel;

    public function __construct()
    {
        // Crear una instancia de DB
        $db = new DB();

        // Crear una instancia de UserModel
        $this->userModel = new UserModel($db);
    }

    public function store()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obtener los datos del formulario
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        // Validar que se hayan enviado ambos campos
        if ($username !== null && $password !== null) {            

            // llamamos al método del modelo para insertar en la base de datos
            try {
                $result = $this->userModel->insertarUsuario($username, $password, "0");

                // Verificar el resultado del modelo
                if ($result) {
                    //lo guardo en el log en logUserCreation() creando instancia
                    $logController = new LogController();
                    $logController->logUserCreation($username, "0");


                    // Si el resultado es exitoso, redirigir al usuario a la página de inicio de sesión
                    header('Location: ../views/login.php?success=Usuario registrado correctamente');
                    exit;
                } else {
                    // Si el resultado no es exitoso, mostrar un mensaje de error
                    throw new Exception("Hubo un problema al intentar registrse.Intentelo de nuevo más tarde.");
                }
            } catch (Exception $e) {
                // Capturar la excepción y redirigir con un mensaje de error
                $errorMessage = urlencode($e->getMessage());
                header("Location: ../views/register.php?error=$errorMessage");
                exit;
            }            
        } 
    } 
}

}

// Crear una instancia de RegisterController
$registerController = new RegisterController();

// Llamar a la función store
$registerController->store();
