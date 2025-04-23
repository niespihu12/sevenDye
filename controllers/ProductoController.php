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
            $alertas = $producto->validar();
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            $imagenesSubidas = [];
            if(count($_FILES['imagen']['tmp_name'])>=4){
                $producto->setAlerta("error", "Solo se permiten 4 imagenes por producto");
            } else{
                if($_FILES['imagen']['tmp_name'][0]){
                    $manager = new Image(Driver::class);
                    foreach($_FILES['imagen']['tmp_name'] as $imagen){
                        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                        $image = $manager->read($imagen)->cover(1000,1000);
                        $image->save(CARPETA_IMAGENES . $nombreImagen);
                        $imagenesSubidas[] = $nombreImagen;
                    }
                }else{
                    $producto->setAlerta("error", "La imagen del producto es obligatoria");
                }
            }

            if(empty($alertas)){
                $producto->crearReferencia();
                $resultado = $producto->guardar();
                $producto = Producto::where('referencia', $producto->referencia);
                if($resultado){
                    foreach($imagenesSubidas as $imagen){
                        $productosImagen = new ProductoImagen([
                            'imagen' => $imagen,
                            'productos_id' => $producto->id
                        ]);
                        $productosImagen->guardar();
                    }

                }
               


            }

        
            
        }

        $alertas = Producto::getAlertas();

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