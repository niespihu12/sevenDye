<?php


namespace Controllers;

use Model\Producto;
use Model\ProductoImagen;
use Model\Talla;
use Model\Color;
use Model\ProductoTalla;
use MVC\Router;

class ProductoController{
    public static function index(Router $router){
        $productos = Producto::all();
        $router->render('productos/index', [
            'productos' => $productos
        ]);
    }

    public static function crear(Router $router){
        $producto = new Producto;
        $tallas = Talla::all();
        $colores = Color::all();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $producto->sincronizar($_POST);
            $alertas = $producto->validar();
            if(empty($alertas)){
                $resultado = $producto->guardar();
                if($resultado){
                    header('Location: /productos');
                }
            }
        }
        $router->render('productos/crear', [
            'alertas' => $alertas,
            'producto' => $producto,
            'tallas' => $tallas,
            'colores' => $colores
        ]);
    }

    public static function actualizar(Router $router){
        $id = validarORedireccionar('/');
        $producto = Producto::find($id);
        $tallas = Talla::all();
        $colores = Color::all();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $producto->sincronizar($_POST);
            $alertas = $producto->validar();
            if(empty($alertas)){
                $resultado = $producto->guardar();
                if($resultado){
                    header('Location: /productos');
                }
            }
        }
        $router->render('productos/actualizar', [
            'alertas' => $alertas,
            'producto' => $producto,
            'tallas' => $tallas,
            'colores' => $colores
        ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $producto = Producto::find($id);
            $producto->eliminar();
            header('Location: /productos');
        }
    }
}


