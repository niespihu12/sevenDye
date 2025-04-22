<?php

namespace Controllers;

use Model\Color;
use MVC\Router;

class ColorController 
{

    public static function index(Router $router){
        session_start();

        isAdmin();
        $colores = Color::all();

        $router->render('colores/admin',[
            'colores' => $colores,
            'pageTitle' => "colores"
        ]);
    }
    public static function crear(Router $router){
        session_start();

        isAdmin();
        $color = new Color; 
        $alertas = Color::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $color = new Color($_POST);

            $alertas = $color->validar();

            if(empty($alertas)){
                $resultado = $color->guardar();

                if($resultado){
                    header('Location: /colores/admin');
                }
            }
        }

        $router->render('colores/crear',[
            'alertas' => $alertas,
            'color' => $color,
            'pageTitle' => "colores"
        ]);
    }
    public static function actualizar(Router $router){
        session_start();

        isAdmin();
        $id = validarORedireccionar('/colores/admin');

        $color = Color::find($id);  
        $alertas = Color::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $args = $_POST;

            $color->sincronizar($args);

            $alertas = $color->validar();

            if(empty($alertas)){
                $resultado = $color->guardar();

                if($resultado){
                    header('Location: /colores/admin');
                }
            }
        }

        $router->render('colores/actualizar',[
            'alertas' => $alertas,
            'color' => $color,
            'pageTitle' => "colores"
        ]);
    }

    public static function eliminar(){
        session_start();

        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
                $color = Color::find($id);
                $resultado = $color->eliminar();
                if ($resultado) {
                    header('location: /colores/admin?resultado=3');
                }
            }
        }
    }

}
