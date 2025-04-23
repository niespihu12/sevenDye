<?php


namespace Controllers;

use MVC\Router;
use Model\Producto;
use Model\ProductoImagen;
use Model\ProductoTalla;
use Model\Talla;
use Model\color;
use Model\Categoria;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

class ProductoController{
    public static function index(Router $router){
        $productos = Producto::all();

        $router->render('productos/admin', [
            'productos' => $productos,
            'pageTitle' => 'Productos'
        ]);
        
    }

    public static function crear(Router $router) {

        $producto = new Producto;
        $categorias = Categoria::all();
        $tallas = Talla::all();
        $colores = Color::all();
        $alertas = Producto::getAlertas();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto = new Producto($_POST);

            

            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            if($_FILES['imagen']['tmp_name']){
                
                
            }

            $alertas = $producto->validar();

        
            
        }

        $router->render('productos/crear', [
            'producto' => $producto,
            'alertas' => $alertas,
            'categorias' => $categorias,
            'tallas' => $tallas,
            'colores' => $colores,
            'pageTitle' => 'Productos'
        ]);
    }
    public static function actualizar(Router $router){
        echo "Hola soy el actualizar de producto";
    }
    public static function eliminar(Router $router){
        echo "Hola soy el eliminar de producto";
    }

    

}