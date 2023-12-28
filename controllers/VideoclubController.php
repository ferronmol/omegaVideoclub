<?php
require_once __DIR__ . '/../models/VideoclubModel.php'; // Asegúrate de incluir el modelo correspondiente

class VideoclubController
{
    private $videoclubModel;

    public function __construct()
    {
        $this->videoclubModel = new VideoclubModel(); // Crea una instancia del modelo
    }

    public function listarPeliculas()
    {
        // Obtener la lista de películas con su reparto
        $peliculas = $this->videoclubModel->getPeliculas();

        // Puedes cargar la vista correspondiente para mostrar la lista de películas
        // y los enlaces de "Modificar" y "Borrar" para los administradores
        include_once '../views/lista_peliculas.php';
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

    // Otras funciones para añadir y modificar películas según sea necesario
}
?>
