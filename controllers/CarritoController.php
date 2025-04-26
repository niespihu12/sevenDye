<?php

namespace Controllers;

use MVC\Router;
use Model\Carrito;
use Model\Producto;


class CarritoController{
    public static function index(Router $router){
        session_start();

        $carItems = Carrito::obtenerCuentaCarrito();
        $total = Carrito::obtenerTotal();


        $router->render('carrito/index', [
            'carItems' => $carItems,
            'total' => $total,
            'moneda' => MONEDA,
        ]);
    }

    public function agregar(){
        session_start();

        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $token = $_POST['token'];

            $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
            if($token === $token_tmp){
                $producto = Producto::find($id);

                if(!$producto || $producto->activo !== 1){
                    $datos['ok'] = false;

                    echo json_encode($datos);
                    return;
                }

                $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;
                $numItems = Carrito::añadirproducto($id, $cantidad);

                $datos['numero'] = $numItems;
                $datos['ok'] = true;

            }else{
                $datos['ok'] = false;
            
            }
        }else{
            $datos['ok'] = false;
        }
        echo json_encode($datos);
    }

    public static function actualizar(){
        session_start();
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : null;

        if($id <= 0 || $cantidad <= 0 || !is_numeric($cantidad)){
            $datos['ok'] = false;
            echo json_encode($datos);
            return;
        }

        $respuesta = Carrito::actualizarProducto($id, $cantidad);

        if($respuesta > 0 ){
            $datos['ok'] = true;
            $datos['subTotal'] = MONEDA . number_format($respuesta, 2);

        }else{
            $datos['ok'] = false;
        }

        echo json_encode($respuesta);
    }

    public static function eliminar(){
        session_start();
        $id = isset($_POST['id']) ? $_POST['id'] : null;

        if($id <= 0){
            $datos['ok'] = false;
            echo json_encode($datos);
            return;
        }

        $respuesta = Carrito::eliminarProducto($id);

        if($respuesta > 0 ){
            $datos['ok'] = true;
        }else{
            $datos['ok'] = false;
        }

        echo json_encode($datos);
    }
}

