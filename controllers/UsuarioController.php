<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

class UsuarioController{
    public static function actualizar(Router $router){
        session_start();
        isAuth();

        $id = filter_var($_SESSION['id'], FILTER_VALIDATE_INT);
        $usuario = Usuario::find($id);

        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $args = $_POST;
            $usuario->sincronizar($args);
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['imagen']['tmp_name']) {
                $manager = new Image(Driver::class); // el gd que viene nativo con php
                $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
                $usuario->setImagen($nombreImagen);
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);
            }
            $usuario->actualizado = date('Y/m/d');
            $resultado = $usuario->guardar();

            if($resultado){
                header('Location: /');
            }

        
            
        }

        $router->render('usuario/perfil',[
            'usuario'=>$usuario,
        ]);
    }
}