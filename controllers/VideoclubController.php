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
}
