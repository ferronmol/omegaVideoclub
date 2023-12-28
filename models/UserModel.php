
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

    public function insertarUsuario($username, $password, $rol)
    {
        try {
            $sql = "INSERT INTO usuarios (username, password, rol) VALUES (?, ?, ?)";
            $stmt = $this->db->getPDO()->prepare($sql);
            $result = $stmt->execute([$username, $password, $rol]);

            if ($result) {
                return true;

            } else {
                // Agrega información adicional sobre el error
                print_r($stmt->errorInfo());
                throw new Exception("Error al ejecutar la consulta: " . implode(", ", $stmt->errorInfo()));
            }
        } catch (Exception $ex) {
            // Puedes manejar el error de alguna manera, como mostrar un mensaje al usuario
            echo '<p class="error">Detalles: ' . $ex->getMessage() . '</p>';
            return false;
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
            return false;
        }
    }
}
