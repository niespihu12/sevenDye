<?php

namespace Controllers;

use MVC\Router;
use Model\Influencer;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

class InfluencerController{
    public static function index(Router $router){
        $influencers = Influencer::all();
        $router->render('/influencers/admin',[
            'influencers' => $influencers, 
        ]);

    }
    public static function crear(Router $router){
        $influencer = new Influencer;
        $alertas = Influencer::getAlertas();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $influencer = new Influencer($_POST['influencer']);
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['influencer']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class); 
                $image = $manager->read($_FILES['influencer']['tmp_name']['imagen'])->cover(600, 800);
                $influencer->setImagen($nombreImagen);
            }
            $alertas = $influencer->validar();
            if (empty($alertas)) {


                if (!is_dir(CARPETA_IMAGENES)) {

                    mkdir(CARPETA_IMAGENES);
                }
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                $resultado = $influencer->guardar();

                if ($resultado) {
                    header('location: /influencers/admin?resultado=1');
                }
            }
        }

        $router->render('/influencers/crear', [
            'influencer' => $influencer,
            'alertas' => $alertas
        ]);
    }
    public static function actualizar(Router $router){
        $id = validarORedireccionar('/influencers/admin');
        $influencer = Influencer::find($id);
        $alertas = Influencer::getAlertas();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $args = $_POST['influencer'];

            $influencer->sincronizar($args);
            $alertas = $influencer->validar();
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['influencer']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class); // el gd que viene nativo con php
                $imagen = $manager->read($_FILES['influencer']['tmp_name']['imagen'])->cover(800, 600);
                $influencer->setImagen($nombreImagen);
            }


            if (empty($alertas)) {
                if ($_FILES['influencer']['tmp_name']['imagen']) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }


                $resultado = $influencer->guardar();

                if ($resultado) {
                    header('location: /influencers/admin?resultado=2');
                }
            }
        }
        $router->render('/influencers/actualizar', [
            'influencer' => $influencer,
            'alertas' => $alertas
        ]);
    }
    public static function eliminar(Router $router){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {

                $tipo = $_POST['tipo'];

                if (validarTipoContenido($tipo)) {
                    $influencer = Influencer::find($id);
                    $resultado = $influencer->eliminar();
                    if ($resultado) {
                        $influencer->borrarImagen();
                        header('location: /influencers/admin?resultado=3');
                    }
                }
            }
        }
    }

}