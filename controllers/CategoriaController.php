<?php


namespace Controllers;

use MVC\Router;
use Model\Categoria;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

class CategoriaController
{
    public static function index(Router $router)
    {
        session_start();

        isAdmin();
        $categorias = Categoria::all();
        $router->render('categorias/admin', [
            'categorias' => $categorias,
            'pageTitle' => 'categorias'
        ]);
    }
    public static function crear(Router $router)
    {
        session_start();

        isAdmin();
        $categoria = new Categoria;
        $alertas = Categoria::getAlertas();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $categoria = new Categoria($_POST);
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['tmp_name']['imagen']) {
                $manager = new Image(Driver::class); // el gd que viene nativo con php
                $image = $manager->read($_FILES['tmp_name']['imagen'])->cover(600, 800);
                $categoria->setImagen($nombreImagen);
            }
            $alertas = $categoria->validar();
            if (empty($alertas)) {
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                $image->save(CARPETA_IMAGENES . $nombreImagen);
                $resultado = $categoria->guardar();

                if ($resultado) {
                    header('location: /categorias/admin?resultado=1');
                }
            }
        }
        $router->render('categorias/crear', [
            'categoria' => $categoria,
            'alertas' => $alertas,
            'pageTitle' => 'categorias'
        ]);
    }

    public static function actualizar(Router $router)
    {
        session_start();

        isAdmin();
        $id = validarORedireccionar('/categorias/admin');
        $categoria = Categoria::find($id);
        $alertas = Categoria::getAlertas();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $args = $_POST;

            $categoria->sincronizar($args);
            $alertas = $categoria->validar();
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['tmp_name']['imagen']) {
                $manager = new Image(Driver::class); // el gd que viene nativo con php
                $imagen = $manager->read($_FILES['tmp_name']['imagen'])->cover(800, 600);
                $categoria->setImagen($nombreImagen);
            }

            if(empty($alertas)){
                if ($_FILES['tmp_name']['imagen']) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }


                $resultado = $categoria->guardar();

                if ($resultado) {
                    header('location: /categorias/admin?resultado=2');
                }
            }
        }

        $router->render('categorias/actualizar',[
            'categoria' => $categoria,
            'alertas' => $alertas,
            'pageTitle' => 'categorias'
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
                $categoria = Categoria::find($id);
                $resultado = $categoria->eliminar();
                if ($resultado) {
                    $categoria->borrarImagen();
                    header('location: /categorias/admin?resultado=3');
                }
            }
        }
    }
}

