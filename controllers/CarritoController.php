<?php
namespace Controllers;

use MVC\Router;
use Model\Carrito;
use Model\Producto;
use Model\ProductoImagen;
use Model\Talla;
use Model\Cupon;

class CarritoController
{
    public static function index(Router $router)
    {
        session_start();
        $carItems = Carrito::obtenerCarrito();
        $imagenes = [];
        foreach ($carItems as $carItem) {
            $imagen = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id = {$carItem['id']} LIMIT 1");
            $imagenes[$carItem['id']] = $imagen[0]->imagen;
        }
        $total = Carrito::obtenerTotal();
        $cupon = Carrito::obtenerCupon();
        $totalConDescuento = Carrito::obtenerTotalConDescuento();

        $router->render('tienda/carrito', [
            'carItems' => $carItems,
            'total' => $total,
            'moneda' => MONEDA,
            'imagenes' => $imagenes,
            'cupon' => $cupon,
            'totalConDescuento' => $totalConDescuento
        ]);
    }

    public static function agregar()
    {
        session_start();
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $token = $_POST['token'];
            $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
            
            if ($token === $token_tmp) {
                $producto = Producto::find($id);

                if (!$producto || $producto->activo != 1) {
                    $datos['ok'] = false;
                    echo json_encode($datos);
                    return;
                }

                $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;
                $talla = isset($_POST['talla']) ? intval($_POST['talla']) : null;
                
                $numItems = Carrito::añadirproducto($id, $cantidad, $talla);

                $datos['numero'] = $numItems;
                $datos['ok'] = true;
            } else {
                $datos['ok'] = false;
            }
        } else {
            $datos['ok'] = false;
        }
        echo json_encode($datos);
    }

    public static function actualizar()
    {
        session_start();
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $clave = isset($data['clave']) ? $data['clave'] : null;
        $cantidad = isset($data['cantidad']) ? $data['cantidad'] : null;

        if (!$clave || $cantidad <= 0 || !is_numeric($cantidad)) {
            $datos['ok'] = false;
            echo json_encode($datos);
            return;
        }

        $respuesta = Carrito::actualizarProducto($clave, $cantidad);

        if ($respuesta > 0) {
            $datos['ok'] = true;
            $datos['subTotal'] = MONEDA . number_format($respuesta, 2);
        } else {
            $datos['ok'] = false;
        }
        echo json_encode($datos);
    }

    public static function eliminar()
    {
        session_start();
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $clave = $data['clave'] ?? null;

        if (!$clave) {
            error_log("Error al eliminar el producto del carrito");
            $datos['ok'] = false;
            echo json_encode($datos);
            return;
        }

        $respuesta = Carrito::eliminarProducto($clave);

        if ($respuesta) {
            $datos['ok'] = true;
        } else {
            $datos['ok'] = false;
        }

        echo json_encode($datos);
    }
    
    public static function aplicarCupon()
    {
        session_start();
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $codigo = $data['codigo'] ?? null;
        
        if (!$codigo) {
            $datos['ok'] = false;
            $datos['mensaje'] = 'El código de cupón es requerido';
            echo json_encode($datos);
            return;
        }
        
        $respuesta = Carrito::aplicarCupon($codigo);
        
        if ($respuesta) {
            $totalConDescuento = Carrito::obtenerTotalConDescuento();
            $total = Carrito::obtenerTotal();
            $descuentoAplicado = $total - $totalConDescuento;
            
            $datos['ok'] = true;
            $datos['mensaje'] = 'Cupón aplicado correctamente';
            $datos['descuento'] = [
                'porcentaje' => $respuesta['descuento'],
                'monto' => MONEDA . number_format($descuentoAplicado, 2)
            ];
            $datos['totalConDescuento'] = MONEDA . number_format($totalConDescuento, 2);
        } else {
            $datos['ok'] = false;
            $datos['mensaje'] = 'El cupón no es válido o está expirado';
        }
        
        echo json_encode($datos);
    }
    
    public static function quitarCupon()
    {
        session_start();
        $respuesta = Carrito::quitarCupon();
        
        if ($respuesta) {
            $datos['ok'] = true;
            $datos['mensaje'] = 'Cupón eliminado correctamente';
        } else {
            $datos['ok'] = false;
            $datos['mensaje'] = 'Error al eliminar el cupón';
        }
        
        echo json_encode($datos);
    }


    public static function contarCarrito() {
        session_start();
        
        $count = Carrito::obtenerCuentaCarrito();
        $count = is_array($count) ? 0 : $count;
        
        echo json_encode(['count' => (int)$count]);
    }
}