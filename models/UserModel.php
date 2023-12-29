
<?php
//tendre que usar getPDO() para obtener la conexion a la base de datos
require_once '../db/DB.php';
/*********************USUARIOS********************* */
class Usuario
{
    private $id;
    private $username;
    private $password;
    private $rol;

    // Constructor para crear una instancia de Usuario
    public function __construct($username, $password, $rol)
    {
        $this->username = $username;
        $this->password = $password;
        $this->rol = $rol;
    }

    // Método para obtener el nombre del usuario
    public function getNombre()
    {
        return $this->username;
    }

    // Método para obtener el password del usuario
    public function getPassword()
    {
        return $this->password;
    }
}
class UserModel
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /*
    ************METODOS PARA USUARIOS************
    */

    // Método para insertar un usuario en la base de datos
    public function insertarUsuario($username, $password, $rol)
{
    try {
        // Validar longitud mínima del password
        if (strlen($password) < 4) {
            throw new Exception("Error: La longitud mínima del password es 4 caracteres.");
        }

        // Encriptación de la contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (username, password, rol) VALUES (?, ?, ?)";
        $stmt = $this->db->getPDO()->prepare($sql);
        $result = $stmt->execute([$username, $passwordHash, $rol]);

        if ($result) {
            return true;
        } else {
            // Verificar si ocurrió una violación de la clave única (username)
            $errorCode = $stmt->errorCode();
            if ($errorCode === '23000' || strpos($stmt->errorInfo()[2], 'Duplicate entry') !== false) {
                // Código de error 23000 indica violación de clave única
                throw new Exception("Error: El nombre de usuario '$username' ya está en uso.");
            } else {
                // Otro tipo de error
                throw new Exception("Error al ejecutar la consulta: " . implode(", ", $stmt->errorInfo()));
            }
        }
    } catch (Exception $ex) {
        // Redirigir a la página de registro con un mensaje de error
        header('Location: ../views/register.php?error=' . urlencode($ex->getMessage()));
        exit();
    }
}


    // Método para verificar si un usuario ya existe
    public function existeUsuario($username)
    {
        try {
            $sql = "SELECT id FROM usuarios WHERE username = ?";
            $stmt = $this->db->getPDO()->prepare($sql);
            $stmt->execute([$username]);  // Cambiado desde $this->$username a $username
            return $stmt->rowCount() > 0;
        } catch (Exception $ex) {
            echo '<p class="error">Detalles: ' . $ex->getMessage() . '</p>';
            return false;
        }
    }

    public function actualizarUsuario($id, $username, $password, $rol)
    {
        try {
            $sql = "UPDATE usuarios SET username = ?, password = ?, rol = ? WHERE id = ?";
            $stmt = $this->db->getPDO()->prepare($sql);
            $result = $stmt->execute([$username, $password, $rol, $id]);

            if ($result) {
                return true;
            } else {
                throw new Exception("Error al ejecutar la consulta: " . implode(", ", $stmt->errorInfo()));
            }
        } catch (Exception $ex) {
            echo '<p class="error">Detalles: ' . $ex->getMessage() . '</p>';
            return false;
        }
    }
    public function borrarUsuario($id)
    {
        try {
            $sql = "DELETE FROM usuarios WHERE id = ?";
            $stmt = $this->db->getPDO()->prepare($sql);
            $result = $stmt->execute([$id]);

            if ($result) {
                return true;
            } else {
                throw new Exception("Error al ejecutar la consulta: " . implode(", ", $stmt->errorInfo()));
            }
        } catch (Exception $ex) {
            echo '<p class="error">Detalles: ' . $ex->getMessage() . '</p>';
            return false;
        }
    }
    public function getUsuario($username)
    {
        try {
            $sql = "SELECT id, username, password, rol FROM usuarios WHERE username = ?";
            $stmt = $this->db->getPDO()->prepare($sql);
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo '<p class="error">Detalles: ' . $ex->getMessage() . '</p>';
            return null;
        }
    }
    // Método para verificar las credenciales del usuario
    public function verificarCredenciales($username, $password)
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE username = ?";
            $stmt = $this->db->getPDO()->prepare($sql);
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Si el usuario existe y la contraseña coincide, retorna true
                return true;
            } else {
                // Si el usuario no existe o la contraseña no coincide, retorna false
                return false;
            }
        } catch (Exception $ex) {
            echo '<p class="error">Detalles: ' . $ex->getMessage() . '</p>';
            return false;
        }
    }

}
