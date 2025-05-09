<?php

namespace Controllers;

use Google\Service\AdExchangeBuyerII\Product;
use Model\Talla;
use MVC\Router;
use Model\ProductoTalla;

class TallaController{
    public static function index(Router $router){
        session_start();

        isAdmin();
        $tallas = Talla::all();

        $router->render('tallas/admin', [
            'tallas' => $tallas,
            'pageTitle' => 'Tallas',
            'titulo' => 'admin'
        ]);
    }

    public static function crear(Router $router){
        session_start();

        isAdmin();
        $talla = new Talla; 
        $alertas = Talla::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $talla = new Talla($_POST);

            $alertas = $talla->validar();

            if(empty($alertas)){
                $resultado = $talla->guardar();

                if($resultado){
                    header('Location: /sizes/admin');
                }
            }
        }

        $router->render('tallas/crear',[
            'alertas' => $alertas,
            'talla' => $talla,
            'pageTitle' => "tallas",
            'titulo' => 'admin'
        ]);
    }
    public static function actualizar(Router $router){
        session_start();

        isAdmin();
        $id = validarORedireccionar('/sizes/admin');

        $talla = Talla::find($id);  
        $alertas = Talla::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $args = $_POST;

            $talla->sincronizar($args);

            $alertas = $talla->validar();

            if(empty($alertas)){
                $resultado = $talla->guardar();

                if($resultado){
                    header('Location: /sizes/admin');
                }
            }
        }

        $router->render('tallas/actualizar',[
            'alertas' => $alertas,
            'talla' => $talla,
            'pageTitle' => "tallas",
            'titulo' => 'admin'
        ]);
    }

    public static function eliminar(){
        session_start();

        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
                $talla = Talla::find($id);
                $productosTallas = ProductoTalla::consultarSQL("SELECT * FROM productos_tallas WHERE tallas_id = {$id}");
                foreach($productosTallas as $productoTalla){
                    $productoTalla->eliminar();
                }
                $resultado = $talla->eliminar();
                if ($resultado) {
                    header('location: /sizes/admin?resultado=3');
                }
            }
        }
    }


}