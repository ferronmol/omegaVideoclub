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
 public function crearPelicula()
 {
   
     // Verificar si el usuario tiene permisos para crear
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

         //creo una instancia de la clase pelicula
            $peliculaNueva = new Pelicula($titulo, $genero, $pais, $anyo, $rutaPelicula);
         // Lógica para guardar los datos de la película
         $newexito = $this->videoclubModel->setPelicula($peliculaNueva);
         ;
 
         if ($newexito) {
             //muestro un mensaje de exito con la modificacion
             $_SESSION['exito_creacion'] = '¡La película se creó con éxito!';
             // redirigo a la zona de edicion con el mensaje de exito
             header('Location: ../views/create_film.php?exito_creacion=1'); 
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
 public function borrarPelicula ($idPelicula)
 {
     // Verificar si el usuario tiene permisos para borrar
     if ($_SESSION['usuario']->getRol() == 1) {
         // Lógica para borrar la película
         $exito = $this->videoclubModel->deletePelicula($idPelicula);
 
         if ($exito) {
             //muestro un mensaje de exito con la modificacion
             $_SESSION['exito_borrado'] = '¡La película se borró con éxito!';
             // redirigo a la zona de edicion con el mensaje de exito
             header('Location: ../views/zonaAdmin.php?exito_borrado=1');
             exit();
         } else {
             // Manejar el error de alguna manera, como mostrar un mensaje al usuario
             echo '<p class="error">Hubo un problema al borrar la película.</p>';
         }
     } else {
         // Redirigir a una página de error si el usuario no tiene permisos
         header('Location: ../views/error.php');
         exit();
     }
 }
}
/****************************************A C T I O N S ********************************************************************* */
//si el action es modificarPelicula (que es el nombre del enlace que se activa al hacer click en MODIFICAR)
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
//si el action es guardarModificacionPelicula (que es el nombre del form de modificacion que se activa al hacer submit)
if (isset($_GET['action']) && $_GET['action'] == 'guardarModificacionPelicula') {
    //recupero el id de la pelicula que quiero modificar
    $idPelicula = $_GET['idPelicula'];  
    // Crear una instancia del controlador
    $videoclubController = new VideoclubController();
    // Llamar al método para guardar la modificación de la película
    $videoclubController->guardarModificacionPelicula($idPelicula);
    exit();
    //lo guardo en el log
    $logController = new LogController();
    //llamo al metodo logAdminAction para escribir en el log
    $logController->logAdminAction($_SESSION['usuario']->getUsername(), $_SESSION['usuario']->getRol(), 'modificarPelicula');
};
//si el action es crearPelicula ( que es el nombre del enlace que se activa al hacer click en INSERTAR PELICULA)
if (isset($_GET['action']) && $_GET['action'] == 'crearPelicula') {
    //permisos
    if (isset($_SESSION['usuario']) && $_SESSION['usuario']->getRol() == 1) {
     //llevo al form que me permite crear la pelicula
     header('Location: ../views/create_film.php');
     exit();
    } else {
        // Redirigir a una página de error si el usuario no tiene permisos
        header('Location: ../views/error.php');
        exit();
    }
};

//si el action es guardarcreacionPelicula ( que es el nombre del form de creacion que se activa al hacer submit)
if (isset($_GET['action']) && $_GET['action'] == 'guardarCreacionPelicula') {  
    // Crear una instancia del controlador
    $videoclubController = new VideoclubController();
    // Llamar al método para crear la película
    $videoclubController->crearPelicula();
    exit();
    //lo guardo en el log
    $logController = new LogController();
    //llamo al metodo logAdminAction para escribir en el log
    $logController->logAdminAction($_SESSION['usuario']->getUsername(), $_SESSION['usuario']->getRol(), 'crearPelicula');
};

//si el action es borrarPelicula ( que es el nombre del enlace que se activa al hacer click en BORRAR PELICULA)
if (isset($_GET['action']) && $_GET['action'] == 'borrarPelicula') {
    //permisos
    if (isset($_SESSION['usuario']) && $_SESSION['usuario']->getRol() == 1) {
    //recupero el id de la pelicula que quiero borrar
    $idPelicula = $_GET['idPelicula'];  
    // Crear una instancia del controlador
    $videoclubController = new VideoclubController();
    // Llamar al método para borrar la película
    $videoclubController->borrarPelicula($idPelicula);
    exit();
    //lo guardo en el log
    $logController = new LogController();
    //llamo al metodo logAdminAction para escribir en el log
    $logController->logAdminAction($_SESSION['usuario']->getUsername(), $_SESSION['usuario']->getRol(), 'borrarPelicula');
    
    } else {
        // Redirigir a una página de error si el usuario no tiene permisos
        header('Location: ../views/error.php');
        exit();
    }
};