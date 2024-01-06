<?php
require_once '../config/Config.php';

class DB
{
    private $pdo;

    public function __construct()
    {
        global $host, $databaseName, $user, $password;

        try {
            // Crea una instancia de PDO para conectarse a la base de datos
            $dsn = "mysql:host=$host;dbname=$databaseName;charset=utf8";
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $ex) {
            echo 'La conexion aun no esta establecida';
            
        }
    }

    // Obtén la instancia de PDO para interactuar con la base de datos
    public function getPDO()
    {
        return $this->pdo;
    }
}
