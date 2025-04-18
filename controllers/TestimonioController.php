<?php

namespace Controllers;

use MVC\Router;
use Model\Testimonio;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

class TestimonioController
{
    public static function index(Router $router)
    {
        $testimonios = Testimonio::all();
        $router->render('/testimonios/admin', [
            'testimonios' => $testimonios,
            'pageTitle' => 'testimonios'
        ]);
    }

    public static function crear(Router $router)
    {
        $testimonio = new Testimonio;
        $alertas = Testimonio::getAlertas();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $testimonio = new Testimonio($_POST['testimonio']);
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['testimonio']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class); // el gd que viene nativo con php
                $image = $manager->read($_FILES['testimonio']['tmp_name']['imagen'])->cover(600, 800);
                $testimonio->setImagen($nombreImagen);
            }
            $alertas = $testimonio->validar();
            if (empty($alertas)) {


                if (!is_dir(CARPETA_IMAGENES)) {

                    mkdir(CARPETA_IMAGENES);
                }
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                $resultado = $testimonio->guardar();

                if ($resultado) {
                    header('location: /testimonios/admin?resultado=1');
                }
            }
        }

        $router->render('/testimonios/crear', [
            'testimonio' => $testimonio,
            'alertas' => $alertas,
            'pageTitle' => 'testimonios'
        ]);
    }
    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/testimonios/admin');
        $testimonio = Testimonio::find($id);
        $alertas = Testimonio::getAlertas();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $args = $_POST['testimonio'];

            $testimonio->sincronizar($args);
            $alertas = $testimonio->validar();
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['testimonio']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class); // el gd que viene nativo con php
                $imagen = $manager->read($_FILES['testimonio']['tmp_name']['imagen'])->cover(800, 600);
                $testimonio->setImagen($nombreImagen);
            }


            if (empty($alertas)) {
                if ($_FILES['testimonio']['tmp_name']['imagen']) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }


                $resultado = $testimonio->guardar();

                if ($resultado) {
                    header('location: /testimonios/admin?resultado=2');
                }
            }
        }
        $router->render('/testimonios/actualizar', [
            'testimonio' => $testimonio,
            'alertas' => $alertas,
            'pageTitle' => 'testimonios'
        ]);
    }

    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {

                $tipo = $_POST['tipo'];

                if (validarTipoContenido($tipo)) {
                    $testimonio = Testimonio::find($id);
                    $resultado = $testimonio->eliminar();
                    if ($resultado) {
                        $testimonio->borrarImagen();
                        header('location: /testimonios/admin?resultado=3');
                    }
                }
            }
        }
    }
}
