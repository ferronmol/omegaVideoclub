<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//necesito primero la clase usuario
require_once __DIR__ . '/../models/UserModel.php';
// Me aseguro  de que ya hay una sesión iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/VideoclubModel.php'; 
// var_dump($_SESSION['usuario']); // ok
// var_dump($_SESSION['exito_modificacion']); // ok
class VideoclubController
{
    private $videoclubModel;
    private $peliculasInfo;

    public function __construct()
    {
        //si el usuario no esta logueado 
        if (!isset($_SESSION['usuario'])) {
            //lo redirijo a la pagina de login
            header('Location: ../views/login.php');
            exit;
        }
        //si el usuario esta logueado
        // Crear una instancia del modelo de películas
        $this->videoclubModel = new VideoclubModel();
    }

    public function listarPeliculas()
    {
        // Obtener la lista de películas con su reparto
        $peliculas = $this->videoclubModel->getPeliculas();

        // Obtener la lista de títulos de películas
        $titulosPeliculas = $this->videoclubModel->getTitulosPeliculas();
        //mandarlo a la vista
        include_once '../views/zonaprivada.php';
    }

    public function borrarPelicula($idPelicula)
    {
        // Lógica para borrar una película
        // Verificar si el usuario tiene permisos para borrar

        if ($_SESSION['rol'] == 1) {
            $this->videoclubModel->borrarPelicula($idPelicula);
            // Puedes redirigir a la lista de películas después de borrar
            header('Location: ./VideoclubController.php?action=listarPeliculas');
            exit();
        } else {
            // Puedes redirigir a una página de error si el usuario no tiene permisos
            //depuro
            echo 'no tienes permisos';

            // header('Location: ./error.php');
            // exit();
        }
    }

    public function listarTitulosPeliculas()
    {
        // Obtener la lista de títulos de películas
        $titulosPeliculas = $this->videoclubModel->getTitulosPeliculas();
        return $titulosPeliculas;
    }

    public function listarPeliculasDetalladas()
    {
        // Obtener la lista de películas detalladas del modelo (con su reparto y duplicados)
        $peliculasDetalladas = $this->videoclubModel->getPeliculasDetalladas();
        //quiero que me devuelva un array con las peliculas detalladas pero que en cada pelicula tenga un array con los actores
        //que cada pelicula tenga un array con los actores
        $peliculasConActores = [];
        // Recorrer el array de películas detalladas
        foreach ($peliculasDetalladas as $pelicula) {
            // Si la película no está en el array de películas con actores
            if (!array_key_exists($pelicula['pelicula_id'], $peliculasConActores)) {
                // Crear un array con los datos de la película
                $peliculasConActores[$pelicula['pelicula_id']] = [
                    'pelicula_id' => $pelicula['pelicula_id'],
                    'pelicula_titulo' => $pelicula['pelicula_titulo'],
                    'pelicula_genero' => $pelicula['pelicula_genero'],
                    'pelicula_pais' => $pelicula['pelicula_pais'],
                    'pelicula_anyo' => $pelicula['pelicula_anyo'],
                    'pelicula_cartel' => '../views/images/peliculas/' . $pelicula['pelicula_cartel'],
                    'actores' => []
                ];
            }
            // Añadir el actor al array de actores de la película
            $peliculasConActores[$pelicula['pelicula_id']]['actores'][] = [
                'actor_id' => $pelicula['actor_id'],
                'actor_nombre' => $pelicula['actor_nombre'],
                'actor_apellidos' => $pelicula['actor_apellidos'],
                'actor_fotografia' => '../views/images/actores/' . $pelicula['actor_fotografia']
            ];
        }

        // Devolver el array de películas con actores
        return array_values($peliculasConActores);
    }
    // funcion para actualizar una pelicula
    public function actualizarPelicula($idPelicula)
    {
        // Obtener la lista de películas detalladas del modelo (con su reparto y duplicados)
        $peliculasDetalladas = $this->videoclubModel->getPeliculaDetallada($idPelicula);
        $peliculasConActores = [];
        // Recorrer el array de películas detalladas
        foreach ($peliculasDetalladas as $pelicula) {
            // Si la película no está en el array de películas con actores
            if (!array_key_exists($pelicula['pelicula_id'], $peliculasConActores)) {
                // Crear un array con los datos de la película
                $peliculasConActores[$pelicula['pelicula_id']] = [
                    'pelicula_id' => $pelicula['pelicula_id'],
                    'pelicula_titulo' => $pelicula['pelicula_titulo'],
                    'pelicula_genero' => $pelicula['pelicula_genero'],
                    'pelicula_pais' => $pelicula['pelicula_pais'],
                    'pelicula_anyo' => $pelicula['pelicula_anyo'],
                    'pelicula_cartel' => '../views/images/peliculas/' . $pelicula['pelicula_cartel'],
                    'actores' => []
                ];
            }
            // Añadir el actor al array de actores de la película
            $peliculasConActores[$pelicula['pelicula_id']]['actores'][] = [
                'actor_id' => $pelicula['actor_id'],
                'actor_nombre' => $pelicula['actor_nombre'],
                'actor_apellidos' => $pelicula['actor_apellidos'],
                'actor_fotografia' =>'../views/images/actores/' . $pelicula['actor_fotografia']
            ];
        }

        // Devolver el array de películas con actores
        return array_values($peliculasConActores);
    }
//funcion para guardar los datos del form de modificacion

public function guardarModificacionPelicula($idPelicula)
{
    // Verificar si el usuario tiene permisos para modificar
    if ($_SESSION['usuario']->getRol() == 1) {
        // Obtener los datos del formulario filtrando los datos recibidos
        $titulo = $_POST['titulo'];
        $genero = $_POST['genero'];
        $pais = $_POST['pais'];
        $anyo = $_POST['anyo'];
        $directorioCarteles = '../views/images/peliculas/';
        if (isset($_FILES['cartel']) && $_FILES['cartel']['error'] == UPLOAD_ERR_OK) {
            $rutaPelicula = $directorioCarteles . $_FILES['cartel']['name'];

            move_uploaded_file($_FILES['cartel']['tmp_name'], $rutaPelicula);
            echo 'hay cartel';
        
        } else {
            $cartel = null;
            echo 'no hay cartel';
        }

        // Lógica para guardar los datos de la película
        $exito = $this->videoclubModel->setModificacionPelicula($titulo, $genero, $pais, $anyo, $idPelicula, $rutaPelicula);

        if ($exito) {
            //muestro un mensaje de exito con la modificacion
            $_SESSION['exito_modificacion'] = '¡La película se modificó con éxito!';
            // redirigo a la zona de edicion con el mensaje de exito
             header('Location: ../views/edit_film.php?idPelicula='.$idPelicula. '&exito_modificacion=1');
            exit();
        
        } else {
            // Manejar el error de alguna manera, como mostrar un mensaje al usuario
            echo '<p class="error">Hubo un problema al modificar la película.</p>';
        }
    } else {
        // Redirigir a una página de error si el usuario no tiene permisos
        header('Location: ../views/error.php');
        exit();
    }
}

}
/************************************************************************************************************* */
//si el action es modificarPelicula
if (isset($_GET['action']) && $_GET['action'] == 'modificarPelicula') {
    //permisos
    if (isset($_SESSION['usuario']) && $_SESSION['usuario']->getRol() == 1) {
        
    //recupero el id de la pelicula que quiero modificar
    $idPelicula = $_GET['idPelicula'];  
     //llevo al form que me permite modificar la pelicula
     header('Location: ../views/edit_film.php?idPelicula='.$idPelicula);
     exit();
    } else {
        // Redirigir a una página de error si el usuario no tiene permisos
        header('Location: ../views/error.php');
        exit();
    }
};
//si el action es guardarModificacionPelicula
if (isset($_GET['action']) && $_GET['action'] == 'guardarModificacionPelicula') {
    //recupero el id de la pelicula que quiero modificar
    $idPelicula = $_GET['idPelicula'];  
    // Crear una instancia del controlador
    $videoclubController = new VideoclubController();
    // Llamar al método para guardar la modificación de la película
    $videoclubController->guardarModificacionPelicula($idPelicula);
    exit();
};

