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
        
        // Obtener los datos del carrito
        $carItems = Carrito::obtenerCarrito();
        $total = Carrito::obtenerTotal();
        $cupon = Carrito::obtenerCupon();
        $totalConDescuento = Carrito::obtenerTotalConDescuento();
        
        // Verificar si hay items en el carrito
        if (empty($carItems)) {
            header('Location: /carrito');
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
            'square_sandbox' => SQUARE_SANDBOX
        ]);
    }
    
    public static function procesarPago() {
        header('Content-Type: application/json');
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            // Obtener los datos del JSON
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
            
            // Si se proporciona un código de cupón y no hay uno aplicado, intentar aplicarlo
            if ($cuponCodigo && !Carrito::obtenerCupon()) {
                Carrito::aplicarCupon($cuponCodigo);
            }
            
            // Crear una instancia de pago Square
            $squarePayment = new Pagos();
            
            // Procesar el pago con el carrito
            $resultado = $squarePayment->procesarPagoCarrito($sourceId, $idempotencyKey);
            
            if ($resultado['success']) {
                // Si el pago es exitoso, guardar la orden
                // Verificar si el usuario está autenticado
                $usuarioId = $_SESSION['usuario_id'] ?? 1; // Usar un valor por defecto si no hay sesión
                
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
            header('Location: /checkout');
        }
    }
    
    public static function procesarPagoProducto(Router $router) {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            // Obtener los datos del JSON
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
            
            // Obtener producto
            $producto = Producto::find($productoId);
            
            if (!$producto || $producto->activo != 1) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El producto no existe o no está disponible'
                ]);
                return;
            }
            
            // Crear una instancia de pago Square
            $squarePayment = new Pagos();
            
            // Procesar el pago del producto
            // FIX: Corrected parameter order to match the method signature
            $resultado = $squarePayment->procesarPagoProducto($producto, $sourceId, $idempotencyKey, $cantidad, $tallaId);
            
            if ($resultado['success']) {
                // Si el pago es exitoso, guardar la orden
                $usuarioId = $_SESSION['usuario_id'] ?? 1; // Usar un valor por defecto si no hay sesión
                
                // Agregar el producto al carrito temporalmente
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
            header('Location: /tienda');
        }
    }
    
    public static function confirmarPago(Router $router) {
        header('Content-Type: application/json');
        session_start();
        
        // Verificar si hay una orden ID en la sesión
        $ordenId = $_GET['orden'] ?? null;
        
        if (!$ordenId) {
            header('Location: /tienda');
            return;
        }
        
        // Aquí podríamos cargar la orden para mostrar un detalle
        
        $router->render('tienda/confirmacion', [
            'ordenId' => $ordenId
        ]);
    }
    
    public static function verificarCupon() {
        header('Content-Type: application/json');
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            // Obtener datos del JSON
            $datos = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($datos['codigo'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El código de cupón es requerido'
                ]);
                return;
            }
            
            $codigo = $datos['codigo'];
            
            // Verificar el cupón
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
            header('Location: /checkout');
        }
    }
}