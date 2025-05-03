<?php

namespace Controllers;

use Model\BlogCategoria;
use MVC\Router;

class BlogCategoriaController
{
    public static function index(Router $router)
    {
        session_start();

        isAdmin();
        $categorias = BlogCategoria::all();

        $router->render('blog_categorias/admin', [
            'categorias' => $categorias,
            'pageTitle' => "Blog categorias"
        ]);
    }

    public static function crear(Router $router){
        session_start();

        isAdmin();
        $categoria = new BlogCategoria; 
        $alertas = BlogCategoria::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $categoria = new BlogCategoria($_POST);

            $alertas = $categoria->validar();

            if(empty($alertas)){
                $resultado = $categoria->guardar();

                if($resultado){
                    header('Location: /blog_categorias/admin');
                }
            }
        }

        $router->render('blog_categorias/crear',[
            'alertas' => $alertas,
            'categoria' => $categoria,
            'pageTitle' => "blog categorias"
        ]);
    }
    public static function actualizar(Router $router){
        session_start();

        isAdmin();
        $id = validarORedireccionar('/blog_categorias/admin');

        $categoria = BlogCategoria::find($id);  
        $alertas = BlogCategoria::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $args = $_POST;

            $categoria->sincronizar($args);

            $alertas = $categoria->validar();

            if(empty($alertas)){
                $resultado = $categoria->guardar();

                if($resultado){
                    header('Location: /blog_categorias/admin');
                }
            }
        }

        $router->render('blog_categorias/actualizar',[
            'alertas' => $alertas,
            'categoria' => $categoria,
            'pageTitle' => "tallas"
        ]);
    }



    public static function eliminar()
    {
        session_start();

        isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $categoria = BlogCategoria::find($id);
                $resultado = $categoria->eliminar();
                if ($resultado) {
                    header('location: /blog_categorias/admin?resultado=3');
                }
            }
        }
    }
}
