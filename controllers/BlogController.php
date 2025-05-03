<?php

namespace Controllers;

use MVC\Router;
use Model\Blog;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;
use Model\BlogCategoria;

class BlogController
{
    public static function index(Router $router)
    {
        session_start();
        
        isAdmin();
        $blogs = Blog::all();
        $router->render('blog/admin', [
            'blogs' => $blogs,
            'pageTitle' => 'blogs'
        ]);
    }

    public static function crear(Router $router)
    {
        session_start();

        isAdmin();
        $blog = new Blog;
        $categorias = BlogCategoria::all();
        $alertas = Blog::getAlertas();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $blog = new Blog($_POST);

            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['imagen']['tmp_name']) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
                $blog->setImagen($nombreImagen);
            }

            $alertas = $blog->validar();

            if (empty($alertas)) {
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                $image->save(CARPETA_IMAGENES . $nombreImagen);
                $blog->creado = date('Y/m/d');
                $resultado = $blog->guardar();

                if ($resultado) {
                    header('location: /blog/admin?resultado=1');
                }
            }
        }

        $router->render('blog/crear', [
            'blog' => $blog,
            'alertas' => $alertas,
            'categorias' => $categorias,
            'pageTitle' => 'blogs'
        ]);
    }

    public static function actualizar(Router $router)
    {
        session_start();

        isAdmin();
        $id = validarORedireccionar('/blogs/admin');
        $categorias = BlogCategoria::all();
        $blog = Blog::find($id);
        $alertas = Blog::getAlertas();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $args = $_POST;

            $blog->sincronizar($args);


            $alertas = $blog->validar();
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            if ($_FILES['imagen']['tmp_name']) {
                $manager = new Image(Driver::class); // el gd que viene nativo con php
                $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
                $blog->setImagen($nombreImagen);
            }

            if (empty($alertas)) {
                if ($_FILES['imagen']['tmp_name']) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $resultado = $blog->guardar();

                if ($resultado) {
                    header('location: /blog/admin?resultado=2');
                }
            }
        }

        $router->render('blog/actualizar', [
            'blog' => $blog,
            'alertas' => $alertas,
            'categorias' => $categorias,
            'pageTitle' => 'blogs'
        ]);
    }

    public static function eliminar(Router $router)
    {
        session_start();

        isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $blog = Blog::find($id);
                $resultado = $blog->eliminar();
                if ($resultado) {
                    $blog->borrarImagen();
                    header('location: /blog/admin?resultado=3');
                }
            }
        }
    }

    public static function buscar()
    {
        header('Content-Type: application/json');

        if (!isset($_GET['q']) || empty($_GET['q'])) {
            echo json_encode([]);
            exit;
        }

        $searchTerm = $_GET['q'];

        $query = "SELECT * FROM blog WHERE 
                titulo LIKE '%{$searchTerm}%' OR 
                contenido LIKE '%{$searchTerm}%' OR 
                slug LIKE '%{$searchTerm}%' 
                LIMIT 6";

        $blogs = Blog::consultarSQL($query);
        $resultados = [];

        foreach ($blogs as $blog) {
            $resultados[] = [
                'id' => $blog->id,
                'titulo' => $blog->titulo,
                'slug' => $blog->slug,
                'contenido' => substr($blog->contenido, 0, 100) . '...',
                'imagen' => $blog->imagen ?? null,
                'creado' => $blog->creado
            ];
        }

        echo json_encode($resultados);
        exit;
    }
}
