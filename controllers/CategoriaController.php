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
        $categorias = Categoria::all();
        $router->render('categorias/admin', [
            'categorias' => $categorias,
            'pageTitle' => 'categorias'
        ]);
    }
    public static function crear(Router $router)
    {
        $categoria = new Categoria;
        $alertas = Categoria::getAlertas();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $categoria = new Categoria($_POST['categoria']);
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['categoria']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class); // el gd que viene nativo con php
                $image = $manager->read($_FILES['categoria']['tmp_name']['imagen'])->cover(600, 800);
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
        $id = validarORedireccionar('/categorias/admin');
        $categoria = Categoria::find($id);
        $alertas = Categoria::getAlertas();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $args = $_POST['categoria'];

            $categoria->sincronizar($args);
            $alertas = $categoria->validar();
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['categoria']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class); // el gd que viene nativo con php
                $imagen = $manager->read($_FILES['categoria']['tmp_name']['imagen'])->cover(800, 600);
                $categoria->setImagen($nombreImagen);
            }

            if(empty($alertas)){
                if ($_FILES['categoria']['tmp_name']['imagen']) {
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {

                $tipo = $_POST['tipo'];

                if (validarTipoContenido($tipo)) {
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
}
