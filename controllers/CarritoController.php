<?php

namespace Controllers;

use MVC\Router;
use Model\Producto;
use Model\Carrito;
use Model\ProductoTalla;
use Model\Talla;
use Model\Cupon;
use Model\ProductoImagen;

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

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            // Obtener datos del JSON
            $datos = json_decode(file_get_contents('php://input'), true);

            if (isset($datos['clave']) && isset($datos['cantidad'])) {
                $resultado = Carrito::actualizarproducto($datos['clave'], $datos['cantidad']);

                echo json_encode([
                    'ok' => true,
                    'subtotal' => $resultado
                ]);
            } else {
                echo json_encode([
                    'ok' => false,
                    'mensaje' => 'Datos incompletos'
                ]);
            }
        } else {
            header('Location: /carrito');
        }
    }

    public static function eliminar()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            // Obtener datos del JSON
            $datos = json_decode(file_get_contents('php://input'), true);

            if (isset($datos['clave'])) {
                $resultado = Carrito::eliminarProducto($datos['clave']);

                echo json_encode([
                    'ok' => $resultado
                ]);
            } else {
                echo json_encode([
                    'ok' => false,
                    'mensaje' => 'Datos incompletos'
                ]);
            }
        } else {
            header('Location: /carrito');
        }
    }

    public static function aplicarCupon()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            // Obtener datos del JSON
            $datos = json_decode(file_get_contents('php://input'), true);

            if (isset($datos['codigo'])) {
                $cupon = Carrito::aplicarCupon($datos['codigo']);

                if ($cupon) {
                    echo json_encode([
                        'ok' => true,
                        'mensaje' => 'Coupon applied successfully',
                        'cupon' => $cupon
                    ]);
                } else {
                    echo json_encode([
                        'ok' => false,
                        'mensaje' => 'Invalid or expired coupon'
                    ]);
                }
            } else {
                echo json_encode([
                    'ok' => false,
                    'mensaje' => 'Coupon code is required'
                ]);
            }
        } else {
            header('Location: /carrito');
        }
    }

    public static function quitarCupon()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $resultado = Carrito::quitarCupon();

            echo json_encode([
                'ok' => $resultado
            ]);
        } else {
            header('Location: /carrito');
        }
    }

    public static function contarCarrito()
    {
        session_start();

        $count = Carrito::obtenerCuentaCarrito();
        $count = is_array($count) ? 0 : $count;

        echo json_encode(['count' => (int)$count]);
    }
}
