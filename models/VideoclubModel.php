<?php

/*********************CREO LAS CLASES********************************************/
class PDOModel  //CLASE PADRE PARA CONECTAR CON LA BASE DE DATOS
{
    private $bd;
    protected $pdo;
    //obtiene una instancia PDO para conectar con la base de datos
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=videoclub', 'root', '');
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

    public function __construct($nombre, $apellidos, $fotografia)
    {
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
    public function getFotografia()
    {
        return $this->fotografia;
    }
}

class VideoclubModel extends PDOModel //clase hija para realizar las consultas
{
    //funcion para listar las peliculas SIN USAR
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
    }
    //funcion para listar las peliculas con su reparto SIN USAR
    public function getTitulosPeliculas()
    {
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
    }
    //************funcion  para listar las peliculas con su reparto******************************
    public function getPeliculasDetalladas()
    {
        $peliculasDetalladas = [];
        try {
            // Obtener la lista de películas con su reparto
            $query = "SELECT
        peliculas.id AS pelicula_id,
        peliculas.titulo AS pelicula_titulo,
        peliculas.genero AS pelicula_genero,
        peliculas.pais AS pelicula_pais,
        peliculas.anyo AS pelicula_anyo,
        peliculas.cartel AS pelicula_cartel,
        actores.id AS actor_id,
        actores.nombre AS actor_nombre,
        actores.apellidos AS actor_apellidos,
        actores.fotografia AS actor_fotografia
    FROM
        peliculas
    JOIN actuan ON peliculas.id = actuan.idpelicula
    JOIN actores ON actuan.idactor = actores.id
    WHERE peliculas.id = actuan.idpelicula";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            // Obtener la lista de películas detalladas
            $peliculasDetalladas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejar errores como desees
            echo '<p class="error">Detalles: ' . $e->getMessage() . '</p>';
        }
        return $peliculasDetalladas;
    }

    //funcion similar que recibe de parametro el id de la pelicula que quiero modificar
    public function getPeliculaDetallada($idPelicula)
    {
        $pelicula = [];
        try {
            // Obtener la lista de películas con su reparto
            $query = "SELECT
        peliculas.id AS pelicula_id,
        peliculas.titulo AS pelicula_titulo,
        peliculas.genero AS pelicula_genero,
        peliculas.pais AS pelicula_pais,
        peliculas.anyo AS pelicula_anyo,
        peliculas.cartel AS pelicula_cartel,
        actores.id AS actor_id,
        actores.nombre AS actor_nombre,
        actores.apellidos AS actor_apellidos,
        actores.fotografia AS actor_fotografia
    FROM
        peliculas
    JOIN actuan ON peliculas.id = actuan.idpelicula
    JOIN actores ON actuan.idactor = actores.id
    WHERE peliculas.id = actuan.idpelicula AND peliculas.id = ?";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$idPelicula]);
            // Obtener la lista de películas detalladas
            $pelicula = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejar errores como desees
            echo '<p class="error">Detalles: ' . $e->getMessage() . '</p>';
        }
        return $pelicula;
    }

    //funcion para introducir los datos de la pelicula modificada

    public function setModificacionPelicula($titulo, $genero, $pais, $anyo, $idPelicula, $rutaPelicula)
    {
        try {
            //tengo que meter solo  el nombre de la imagin sin la ruta
            $cartel = basename($rutaPelicula); // devuelve el nombre del archivo con su extension

            $query = "UPDATE peliculas SET titulo = ?, genero = ?, pais = ?, anyo = ? , cartel = ?  WHERE id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$titulo, $genero, $pais, $anyo, $cartel, $idPelicula]);

            return true;
        } catch (PDOException $e) {
            // Puedes manejar el error de alguna manera, como mostrar un mensaje al usuario
            echo '<p class="error">Detalles: ' . $e->getMessage() . '</p>';
            return false;
        }
    }

    public function setPelicula(Pelicula $peliculaNueva)
    {
        try {
            //igualmente solo meto el nombre de la imagen sin la ruta
            $cartel = basename($peliculaNueva->getCartel());
            $query = "INSERT INTO peliculas (titulo, genero, pais, anyo, cartel) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$peliculaNueva->getTitulo(), $peliculaNueva->getGenero(), $peliculaNueva->getPais(), $peliculaNueva->get_anyo(), $cartel]);

            // Obtener el ID de la película recién insertada (para insertar el reparto)
            $idPelicula = $this->pdo->lastInsertId();
            //obtener el ultimo id de la tabla actores para poder insertar el siguiente
            $queryUltimoIdActor = "SELECT MAX(id) FROM actores";
            $stmtUltimoIdActor = $this->pdo->prepare($queryUltimoIdActor);
            $stmtUltimoIdActor->execute();
            $ultimoIdActor = $stmtUltimoIdActor->fetchColumn();
            $nuevoIdActor = $ultimoIdActor + 1;
            //priemro lo inserto en la tabla actores para evitar violacion en actuan
            $queryInsertarActor = "INSERT INTO actores (id) VALUES (?)";
            $stmtInsertarActor = $this->pdo->prepare($queryInsertarActor);
            $stmtInsertarActor->execute([$nuevoIdActor]); //ojo , como array
            //inserto en la tabla actuan
            $queryActuan = "INSERT INTO actuan (idpelicula, idactor) VALUES (?, ?)";
            $stmtActuan = $this->pdo->prepare($queryActuan);
            $stmtActuan->execute([$idPelicula, $nuevoIdActor]);

            return true;
        } catch (PDOException $e) {
            echo '<p class="error">Detalles: ' . $e->getMessage() . '</p>';
            return false;
        } catch (Exception $e) {
            echo '<p class="error">Detalles no controlados: ' . $e->getMessage() . '</p>';
            return false;
        }
    }

    public function deletePelicula($idPelicula)
    {
        try {
            //debo borrar primero de la tabla actuan y luego de peliculas
            $queryActuan = "DELETE FROM actuan WHERE idpelicula = ?";
            $stmtActuan = $this->pdo->prepare($queryActuan);
            $stmtActuan->execute([$idPelicula]);
            $queryPeliculas = "DELETE FROM peliculas WHERE id = ?";
            $stmtPeliculas = $this->pdo->prepare($queryPeliculas);
            $stmtPeliculas->execute([$idPelicula]);
            

            return true;
        } catch (PDOException $e) {
            echo '<p class="error">Detalles: ' . $e->getMessage() . '</p>';
            return false;
        }
    }
}
