<?php

namespace Controllers;

use MVC\Router;
use Model\Producto;
use Model\Carrito;
use Model\Cupon;
use Model\Pagos;

class PagoController {
    
    public static function checkout(Router $router) {
        session_start();
        
        $carItems = Carrito::obtenerCarrito();
        $total = Carrito::obtenerTotal();
        $cupon = Carrito::obtenerCupon();
        $totalConDescuento = Carrito::obtenerTotalConDescuento();
        
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
            'square_application_id' => SQUARE_APPLICATION_ID,
            'square_location_id' => SQUARE_LOCATION_ID,
            'square_sandbox' => SQUARE_SANDBOX,
            'titulo' => 'payment'
        ]);
    }
    
    public static function procesarPago() {
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
            if ($cuponCodigo && !Carrito::obtenerCupon()) {
                Carrito::aplicarCupon($cuponCodigo);
            }
            $squarePayment = new Pagos();
            $resultado = $squarePayment->procesarPagoCarrito($sourceId, $idempotencyKey);
            
            if ($resultado['success']) {
                $usuarioId = $_SESSION['usuario_id'] ?? 1; 
                
                $ordenId = $squarePayment->guardarOrden($usuarioId);
                
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
    
    public static function procesarPagoProducto(Router $router) {
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
                Carrito::añadirproducto($productoId, $cantidad, $tallaId);
                
                $ordenId = $squarePayment->guardarOrden($usuarioId);
                
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
    
    public static function confirmarPago(Router $router) {
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
    
    public static function verificarCupon() {
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