<?php
require_once '../config/Config.php';

class DB {
    private $pdo;

    public function __construct() {
        global $host, $dbname, $user, $password;
       
        try {
            //crea una instancia de PDO para conectarse a la base de datos
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo 'Error de conexión: ' . $ex->getMessage();
            echo '<pre>' . print_r($ex->getTrace(), true) . '</pre>';
        }
    }
    //obtener la instancia de PDO para interactuar con la base de datos
    public function getPDO() {
        return $this->pdo;
    }
}