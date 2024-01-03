<?php
require_once __DIR__ . '/../models/VideoclubModel.php'; // Incluir el modelo de películas


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
            header('Location: ./error.php');
            exit();
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
                'pelicula_cartel' => base64_encode($pelicula['pelicula_cartel']),
                'actores' => []
            ];
        }
        // Añadir el actor al array de actores de la película
        $peliculasConActores[$pelicula['pelicula_id']]['actores'][] = [
            'actor_id' => $pelicula['actor_id'],
            'actor_nombre' => $pelicula['actor_nombre'],
            'actor_apellidos' => $pelicula['actor_apellidos'],
            'actor_fotografia' => base64_encode($pelicula['actor_fotografia'])
        ];
    }

    // Devolver el array de películas con actores
    return array_values($peliculasConActores);
    }

    public function guardarFotosActores()
{
    // Obtener la lista de películas detalladas del modelo (con su reparto y duplicados)
    $peliculasDetalladas = $this->videoclubModel->getPeliculasDetalladas();

    foreach ($peliculasDetalladas as $pelicula) {
        foreach ($pelicula['actores'] as $actor) {
            // Comprobar si el actor tiene una foto
            if (isset($actor['actor_fotografia'])) {
                // Crear la ruta al archivo de la imagen
                $rutaImagen = "../views/images/actores/" . $actor['actor_fotografia'];

                // Comprobar si el archivo ya existe
                if (!file_exists($rutaImagen)) {
                    // Obtener los datos de la imagen de la base de datos
                    $datosImagen = $actor['actor_fotografia'];

                    // Guardar los datos de la imagen en un archivo
                    file_put_contents($rutaImagen, $datosImagen);
                }
            }
        }
    }
}

}

