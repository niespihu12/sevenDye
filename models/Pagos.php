<?php

namespace Model;

use Square\Legacy\SquareClient;
use Square\Legacy\Environment;
use Square\Legacy\Exceptions\ApiException;
use Square\Legacy\Models\CreatePaymentRequest;
use Square\Legacy\Models\Money;
use Square\Legacy\Models\CreateOrderRequest;
use Square\Legacy\Models\Order;
use Square\Legacy\Models\OrderLineItem;
use Square\Legacy\Models\OrderLineItemDiscount;
use Square\Legacy\Models\OrderLineItemDiscountType;

class pagos extends ActiveRecord
{
    protected static $tabla = 'pagos';
    protected static $columnasDB = [
        'id',
        'referencia',
        'monto',
        'estado',
        'ordenes_id',
        'creado',
        'actualizado'
    ];

    public $id;
    public $referencia;
    public $monto;
    public $estado;
    public $ordenes_id;
    public $creado;
    public $actualizado;

    protected $client;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->referencia = $args['referencia'] ?? '';
        $this->monto = $args['monto'] ?? '';
        $this->estado = $args['estado'] ?? 'pendiente';
        $this->ordenes_id = $args['ordenes_id'] ?? null;
        $this->creado = $args['creado'] ?? date('Y-m-d');
        $this->actualizado = $args['actualizado'] ?? date('Y-m-d');

        // Inicializar cliente Square
        $this->inicializarCliente();
    }

    private function inicializarCliente()
    {
        $environment = SQUARE_SANDBOX ? Environment::SANDBOX : Environment::PRODUCTION;

        $this->client = new SquareClient([
            'accessToken' => SQUARE_ACCESS_TOKEN,
            'environment' => $environment
        ]);
    }

    public function validar()
    {
        if (!$this->monto) {
            self::$alertas['error'][] = 'El monto es obligatorio';
        }

        if (!$this->estado) {
            self::$alertas['error'][] = 'El estado es obligatorio';
        }

        return self::$alertas;
    }

    public function procesarPagoProducto($producto, $sourceId, $idempotencyKey, $cantidad = 1, $talla = null)
    {
        try {
            $precioUnitario = $producto->precio;

            // Si hay talla, buscar el precio específico
            if ($talla) {
                $productoTalla = ProductoTalla::consultarSQL(
                    "SELECT * FROM productos_tallas WHERE productos_id = {$producto->id} AND tallas_id = {$talla} AND activo = 1"
                );

                if ($productoTalla && !empty($productoTalla) && $productoTalla[0]->precio !== null) {
                    $precioUnitario = $productoTalla[0]->precio;
                }
            }

            $totalCentavos = round($precioUnitario * $cantidad * 100); // Convertir a centavos

            // Crear request de pago
            $request = new CreatePaymentRequest($sourceId, $idempotencyKey);
            $request->setAmountMoney(new Money($totalCentavos, SQUARE_CURRENCY));

            // Añadir referencia para rastreo
            $request->setReferenceId("producto-{$producto->id}");
            $request->setNote("Compra de {$cantidad} unidad(es) de {$producto->nombre}");

            // Ejecutar la solicitud de pago
            $response = $this->client->getPaymentsApi()->createPayment($request);

            if ($response->isSuccess()) {
                $payment = $response->getResult()->getPayment();
                $this->referencia = $payment->getId();
                $this->monto = $precioUnitario * $cantidad;
                $this->estado = 'completado';

                return [
                    'success' => true,
                    'payment_id' => $payment->getId(),
                    'amount' => $totalCentavos / 100 // Convertir de centavos a unidad monetaria
                ];
            } else {
                $errors = $response->getErrors();
                return [
                    'success' => false,
                    'errors' => $errors
                ];
            }
        } catch (ApiException $e) {
            return [
                'success' => false,
                'errors' => $e->getMessage()
            ];
        }
    }


    public function procesarPagoCarrito($sourceId, $idempotencyKey)
    {
        try {
            $cartItems = Carrito::obtenerCarrito();

            if (empty($cartItems)) {
                return ['success' => false, 'errors' => 'El carrito está vacío'];
            }

            // Validate sourceId and idempotencyKey
            if (empty($sourceId) || empty($idempotencyKey)) {
                return [
                    'success' => false,
                    'errors' => 'Token de pago o clave de idempotencia no proporcionados'
                ];
            }

            // Calculate the total in the base currency (dollars, euros, etc.)
            $totalBaseAmount = 0;

            foreach ($cartItems as $item) {
                // Validate quantity
                $quantity = intval($item['cantidad']);
                if ($quantity <= 0) continue;

                $precio = floatval($item['precio'] ?? 0);

                if ($precio <= 0) {
                    return [
                        'success' => false,
                        'errors' => "Precio inválido para {$item['producto']->nombre}"
                    ];
                }

                // Add to total in base currency
                $totalBaseAmount += $precio * $quantity;
            }

            // Apply coupon discount if available
            $cupon = Carrito::obtenerCupon();
            $totalConDescuento = $totalBaseAmount;

            if ($cupon) {
                if ($cupon['tipo_descuento'] === 'porcentaje') {
                    $descuento = $totalBaseAmount * ($cupon['descuento'] / 100);
                    $totalConDescuento -= $descuento;
                } else {
                    $descuento = $cupon['descuento'];
                    $totalConDescuento -= $descuento;
                }
            }

            // Add shipping cost if applicable ($7.00 for orders under $200)
            if ($totalConDescuento <= 200) {
                $totalConDescuento += 7.00;
            }

            // Store the final amount in base currency for later database storage
            $finalAmountBaseUnits = $totalConDescuento;

            // Convert to cents for Square API (Square requires integer amounts in cents)
            $totalCentavos = round($totalConDescuento * 100);

            // Ensure minimum amount of 1 cent
            $totalCentavos = max(1, (int)$totalCentavos);

            // Create Money object for Square
            $money = new Money();
            $money->setAmount($totalCentavos);
            $money->setCurrency(SQUARE_CURRENCY);

            // Create the payment request
            $request = new CreatePaymentRequest(
                $sourceId,
                $idempotencyKey
            );

            $request->setAmountMoney($money);
            $request->setAutocomplete(true);
            $request->setReferenceId("carrito-" . uniqid());
            $request->setNote("Compra de carrito online");

            // Execute the payment request
            $response = $this->client->getPaymentsApi()->createPayment($request);

            if ($response->isSuccess()) {
                $payment = $response->getResult()->getPayment();
                $this->referencia = $payment->getId();

                // IMPORTANT FIX: Store the amount in base currency, not cents
                // This is the original amount we calculated BEFORE converting to cents
                $this->monto = $finalAmountBaseUnits;
                $this->estado = 'completado';

                return [
                    'success' => true,
                    'payment_id' => $payment->getId(),
                    'amount' => $finalAmountBaseUnits  // Return the amount in base currency
                ];
            } else {
                $errors = $response->getErrors();
                return [
                    'success' => false,
                    'errors' => $errors
                ];
            }
        } catch (ApiException $e) {
            return [
                'success' => false,
                'errors' => $e->getMessage()
            ];
        }
    }

    public function guardarOrden($usuarioId)
    {
        // Crear nueva orden
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
            $this->ordenes_id = $ordenId;
            $this->guardar();

            // Guardar los artículos de la orden
            $cartItems = Carrito::obtenerCarrito();
            foreach ($cartItems as $item) {
                $articuloOrden = new ArticuloOrden([
                    'cantidad' => $item['cantidad'],
                    'costo_por_unidad' => $item['precio'],
                    'ordenes_id' => $ordenId,
                    'productos_id' => $item['id']
                ]);

                $articuloOrden->guardar();

                // Actualizar el stock del producto
                $producto = Producto::find($item['id']);
                if ($producto) {
                    $producto->cantidad = max(0, $producto->cantidad - $item['cantidad']);
                    $producto->recuento_ventas = $producto->recuento_ventas + $item['cantidad'];
                    $producto->guardar();
                }
            }

            // Limpiar carrito después de guardar la orden
            Carrito::limpiarCarrito();

            return $ordenId;
        }

        return false;
    }
}
