<?php

class PDOModel {
    private $bd;
    protected $pdo;
    //obtiene una instancia PDO para conectar con la base de datos
    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=videoclub','root','');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bd = new DB();
        $this->pdo = $this->bd->getPDO();
    }
}


/*********************PELICULAS*********************/
class Pelicula 
{
    private $id;
    private $titulo;
    private $genero;    
    private $pais;
    private $anyo;
    private $cartel;

    public function __construct($titulo, $genero, $pais, $anyo, $cartel) 
    {
        $this->titulo = $titulo;
        $this->genero = $genero;
        $this->pais = $pais;
        $this->anyo = $anyo;
        $this->cartel = $cartel;
    }
    
    // Constructor para crear una instancia de Pelicula
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function getGenero()
    {
        return $this->genero;
    }
    public function getPais()
    {
        return $this->pais;
    }
    public function getCartel()
    {
        return $this->cartel;
    }
    public function get_anyo()
    {
        return $this->anyo;
    }
}

class Actor 
{
    private $id;
    private $nombre;
    private $apellidos;
    private $fotografia;

    public function __construct( $nombre, $apellidos, $fotografia) {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fotografia = $fotografia;
    }
    // Constructor para crear una instancia de Actor
    public function getNombre()
    {
        return $this->nombre;
    }
    public function get_apellidos() 
    {
        return $this->apellidos;
    }
    public function get_fotografia() 
    {
        return $this->fotografia;
    }
  
}	

class VideoclubModel extends PDOModel {
public function getPeliculas()
    {
        $peliculas = [];
     try {
            $query = "SELECT id, titulo, genero, pais, anyo, cartel FROM peliculas";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            // Obtener la lista de películas con su reparto utilizo el metodo fetchAll para obtener un array con todas las filas
            $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Puedes manejar el error de alguna manera, como mostrar un mensaje al usuario
            echo '<p class="error">Detalles: ' . $e->getMessage() . '</p>';
        }
        return $peliculas;
        //depuro
        //var_dump($peliculas);

    }
    public function getTitulosPeliculas(){
        $titulosPeliculas = [];
        try {
            $query = "SELECT titulo FROM peliculas";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            // Obtener la lista de títulos de películas
            $titulosPeliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Puedes manejar el error de alguna manera, como mostrar un mensaje al usuario
            echo '<p class="error">Detalles: ' . $e->getMessage() . '</p>';
        }
        return $titulosPeliculas;
        //depuro
        //var_dump($titulosPeliculas);
    }

    public function agregarPelicula(Pelicula $pelicula)
    {
        try {
            $query = "INSERT INTO peliculas (titulo, genero, pais, anyo, cartel) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                $pelicula->getTitulo(),
                $pelicula->getGenero(),
                $pelicula->getPais(),
                $pelicula->get_anyo(),
                $pelicula->getCartel()
            ]);

            return true;
        } catch (PDOException $e) {
            // Puedes manejar el error de alguna manera, como mostrar un mensaje al usuario
            echo '<p class="error">Detalles: ' . $e->getMessage() . '</p>';
            return false;
        }
    }

    public function borrarPelicula($idPelicula)
    {
        try {
            $query = "DELETE FROM peliculas WHERE id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$idPelicula]);

            return true;
        } catch (PDOException $e) {
            // Puedes manejar el error de alguna manera, como mostrar un mensaje al usuario
            echo '<p class="error">Detalles: ' . $e->getMessage() . '</p>';
            return false;
        }
    }
    
}
?>
