<?php

namespace Controllers;

use MVC\Router;
use Model\Producto;
use Model\Carrito;
use Model\Cupon;
use Model\Pagos;
use Model\BillingDetail;
use Model\ProductoImagen;
use Model\ProductoTalla;
use Model\Orden;
use Model\ArticuloOrden;

class PagoController
{

    public static function checkout(Router $router)
    {
        session_start();

        $carItems = Carrito::obtenerCarrito();
        $total = Carrito::obtenerTotal();
        $cupon = Carrito::obtenerCupon();
        $totalConDescuento = Carrito::obtenerTotalConDescuento();
        $imagenes = [];
        foreach ($carItems as $item) {
            $imagenes[$item['clave']] = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id = {$item['producto']->id}");
        }
        if (empty($carItems)) {
            header('Location: /cart');
            return;
        }

        $router->render('tienda/checkout', [
            'carItems' => $carItems,
            'total' => $total,
            'cupon' => $cupon,
            'totalConDescuento' => $totalConDescuento,
            'moneda' => MONEDA,
            'imagenes' => $imagenes,
            'square_application_id' => SQUARE_APPLICATION_ID,
            'square_location_id' => SQUARE_LOCATION_ID,
            'square_sandbox' => SQUARE_SANDBOX,
            'titulo' => 'payment'
        ]);
    }

    public static function buyNow(Router $router)
    {
        session_start();
        if (!isset($_GET['id']) || !isset($_GET['token']) || !isset($_GET['cantidad']) || !isset($_GET['talla'])) {
            header('Location: /store');
            return;
        }

        $id = $_GET['id'];
        $token = $_GET['token'];
        $cantidad = $_GET['cantidad'];
        $tallaId = $_GET['talla'];
        if (!hash_equals(hash_hmac('sha1', $id, KEY_TOKEN), $token)) {
            header('Location: /store');
            return;
        }
        $producto = Producto::find($id);

        if (!$producto || $producto->activo != 1) {
            header('Location: /store');
            return;
        }
        $precio = $producto->precio;

        if ($tallaId) {
            $productoTalla = ProductoTalla::consultarSQL(
                "SELECT * FROM productos_tallas WHERE productos_id = {$id} AND tallas_id = {$tallaId} AND activo = 1"
            );

            if ($productoTalla && !empty($productoTalla) && $productoTalla[0]->precio !== null) {
                $precio = $productoTalla[0]->precio;
            }
        }
        $total = $precio * $cantidad;
        $costoEnvio = 0;
        if ($total <= 200) {
            $costoEnvio = 7.00;
            $totalConEnvio = $total + $costoEnvio;
        } else {
            $totalConEnvio = $total;
        }
        $imagenes = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id = {$id}");
        $imagenPrincipal = !empty($imagenes) ? $imagenes[0]->imagen : '';

        $router->render('tienda/buy-now', [
            'producto' => $producto,
            'cantidad' => $cantidad,
            'talla_id' => $tallaId,
            'precio' => $precio,
            'total' => $total,
            'costoEnvio' => $costoEnvio,
            'totalConEnvio' => $totalConEnvio,
            'moneda' => MONEDA,
            'imagen' => $imagenPrincipal,
            'square_application_id' => SQUARE_APPLICATION_ID,
            'square_location_id' => SQUARE_LOCATION_ID,
            'square_sandbox' => SQUARE_SANDBOX,
            'titulo' => 'Buy Now'
        ]);
    }

    public static function procesarPago()
    {
        header('Content-Type: application/json');
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

            $datos = json_decode(file_get_contents('php://input'), true);

            if (!isset($datos['sourceId']) || !isset($datos['idempotencyKey'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Faltan datos para procesar el pago'
                ]);
                return;
            }

            $sourceId = $datos['sourceId'];
            $idempotencyKey = $datos['idempotencyKey'];
            $cuponCodigo = $datos['cuponCodigo'] ?? null;

            // Obtener datos de facturación
            $billingData = isset($datos['billingDetails']) ? $datos['billingDetails'] : null;

            // Validar datos de facturación
            if ($billingData) {
                $billingDetail = new BillingDetail($billingData);
                $alertas = $billingDetail->validar();

                if (!empty($alertas)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error en los datos de facturación',
                        'errors' => $alertas
                    ]);
                    return;
                }
            }

            if ($cuponCodigo && !Carrito::obtenerCupon()) {
                Carrito::aplicarCupon($cuponCodigo);
            }
            $squarePayment = new Pagos();
            $resultado = $squarePayment->procesarPagoCarrito($sourceId, $idempotencyKey);

            if ($resultado['success']) {
                $usuarioId = $_SESSION['usuario_id'] ?? 1;

                $ordenId = $squarePayment->guardarOrden($usuarioId, $billingData);

                if ($ordenId) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Pago procesado correctamente',
                        'orden_id' => $ordenId,
                        'payment_id' => $resultado['payment_id']
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al guardar la orden'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al procesar el pago',
                    'errors' => $resultado['errors']
                ]);
            }
        } else {
            header('Location: /payment');
        }
    }

    public static function procesarPagoProducto(Router $router)
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

            $datos = json_decode(file_get_contents('php://input'), true);

            if (!isset($datos['sourceId']) || !isset($datos['idempotencyKey']) || !isset($datos['productoId'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Faltan datos para procesar el pago'
                ]);
                return;
            }

            $sourceId = $datos['sourceId'];
            $idempotencyKey = $datos['idempotencyKey'];
            $productoId = $datos['productoId'];
            $cantidad = $datos['cantidad'] ?? 1;
            $tallaId = $datos['tallaId'] ?? null;
            $billingData = isset($datos['billingDetails']) ? $datos['billingDetails'] : null;

            // Validar datos de facturación
            if ($billingData) {
                $billingDetail = new BillingDetail($billingData);
                $alertas = $billingDetail->validar();

                if (!empty($alertas)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error en los datos de facturación',
                        'errors' => $alertas
                    ]);
                    return;
                }
            }

            $producto = Producto::find($productoId);

            if (!$producto || $producto->activo != 1) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El producto no existe o no está disponible'
                ]);
                return;
            }

            $squarePayment = new Pagos();
            $resultado = $squarePayment->procesarPagoProducto($producto, $sourceId, $idempotencyKey, $cantidad, $tallaId);

            if ($resultado['success']) {
                $usuarioId = $_SESSION['usuario_id'] ?? 1;

                // Ahora usamos un método específico para guardar órdenes de productos individuales
                // en lugar de añadir al carrito
                $ordenId = self::guardarOrdenProductoIndividual(
                    $squarePayment,
                    $usuarioId,
                    $producto,
                    $cantidad,
                    $tallaId,
                    $billingData,
                    $resultado['payment_id']
                );

                if ($ordenId) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Pago procesado correctamente',
                        'orden_id' => $ordenId,
                        'payment_id' => $resultado['payment_id']
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al guardar la orden'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al procesar el pago',
                    'errors' => $resultado['errors']
                ]);
            }
        } else {
            header('Location: /store');
        }
    }

   
    private static function guardarOrdenProductoIndividual($pago, $usuarioId, $producto, $cantidad, $tallaId, $billingData, $paymentId)
    {
        $orden = new Orden([
            'referencia' => 'ORD-' . uniqid(),
            'estado' => 'pagado',
            'creado' => date('Y-m-d'),
            'actualizado' => date('Y-m-d'),
            'usuarios_id' => $usuarioId
        ]);

        $resultado = $orden->guardar();
        $orden_id = Orden::where('referencia', $orden->referencia);

        if ($resultado) {
            $ordenId = $orden_id->id;
            $pago->ordenes_id = $ordenId;
            $pago->referencia = $paymentId;
            $pago->guardar();
            if ($billingData) {
                $billingData['ordenes_id'] = $ordenId;
                $billingDetails = new BillingDetail($billingData);
                $billingDetails->guardar();
            }
            $precio = $producto->precio;
            if ($tallaId) {
                $productoTalla = ProductoTalla::consultarSQL(
                    "SELECT * FROM productos_tallas WHERE productos_id = {$producto->id} AND tallas_id = {$tallaId} AND activo = 1"
                );

                if ($productoTalla && !empty($productoTalla) && $productoTalla[0]->precio !== null) {
                    $precio = $productoTalla[0]->precio;
                }
            }
            $tallaDB = null;
            if ($tallaId) {
                $tallaDB = $tallaId;
            }

            
            $articuloOrden = new ArticuloOrden([
                'cantidad' => $cantidad,
                'costo_por_unidad' => $precio,
                'tallas_id' => $tallaDB,
                'ordenes_id' => $ordenId,
                'productos_id' => $producto->id
            ]);
            $articuloOrden->guardar();

            // Actualizar el stock del producto
            $producto->cantidad = max(0, $producto->cantidad - $cantidad);
            $producto->recuento_ventas = $producto->recuento_ventas + $cantidad;
            $producto->guardar();

            return $ordenId;
        }

        return false;
    }

    public static function confirmarPago(Router $router)
    {
        header('Content-Type: application/json');
        session_start();
        $ordenId = $_GET['orden'] ?? null;

        if (!$ordenId) {
            header('Location: /store');
            return;
        }

        $router->render('tienda/confirmacion', [
            'ordenId' => $ordenId,
            'titulo' => 'confirmation'
        ]);
    }

    public static function verificarCupon()
    {
        header('Content-Type: application/json');
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

            $datos = json_decode(file_get_contents('php://input'), true);

            if (!isset($datos['codigo'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El código de cupón es requerido'
                ]);
                return;
            }

            $codigo = $datos['codigo'];


            $cupon = Cupon::verificarCupon($codigo);

            if ($cupon) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Cupón válido',
                    'cupon' => $cupon
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Cupón inválido o expirado'
                ]);
            }
        } else {
            header('Location: /payment');
        }
    }
}
