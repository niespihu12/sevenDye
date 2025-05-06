<?php

namespace Model;

class Carrito {
    public static function carrito() {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [
                'productos' => [],
                'cupon' => null
            ];
        }
    }

    public static function añadirproducto($id, $cantidad, $talla = null) {
        self::carrito();
        $clave = $talla ? $id . '_' . $talla : $id;
        
        if (isset($_SESSION['carrito']['productos'][$clave])) {
            $_SESSION['carrito']['productos'][$clave]['cantidad'] += $cantidad;
        } else {
            $_SESSION['carrito']['productos'][$clave] = [
                'id' => $id,
                'cantidad' => $cantidad,
                'talla' => $talla
            ];
        }
        
        return count($_SESSION['carrito']['productos']);
    }

    public static function actualizarproducto($clave, $cantidad) {
        self::carrito();
        
        if ($cantidad > 0 && is_numeric($cantidad)) {
            if (isset($_SESSION['carrito']['productos'][$clave])) {
                $datosProducto = $_SESSION['carrito']['productos'][$clave];
                $id = $datosProducto['id'];
                $talla = $datosProducto['talla'] ?? null;
                $_SESSION['carrito']['productos'][$clave]['cantidad'] = $cantidad;
                
                $producto = Producto::find($id);
                if ($producto && $producto->activo == 1) {
                    $precio = $producto->precio;
                    
                    // Si hay talla, buscar el precio específico para esa talla
                    if ($talla) {
                        $condiciones = [
                            'productos_id' => $id,
                            'tallas_id' => $talla,
                            'activo' => 1
                        ];
                        $productoTalla = ProductoTalla::consultarSQL("SELECT * FROM productos_tallas WHERE productos_id =  {$condiciones['productos_id']} AND tallas_id = {$condiciones['tallas_id']} AND activo = {$condiciones['activo']}");
                        
                        if ($productoTalla && !empty($productoTalla) && $productoTalla[0]->precio !== null) {
                            $precio = $productoTalla[0]->precio;
                        }
                    }
                    
                    return $cantidad * $precio;
                }
            }
        }
        
        return 0;
    }

    public static function eliminarProducto($clave) {
        self::carrito();
        
        if (isset($_SESSION['carrito']['productos'][$clave])) {
            unset($_SESSION['carrito']['productos'][$clave]);
            return true;
        }
        
        return false;
    }

    public static function aplicarCupon($codigo) {
        self::carrito();
        
        // Verificar que el carrito no esté vacío
        if (empty($_SESSION['carrito']['productos'])) {
            return false;
        }
        
        $cupon = Cupon::verificarCupon($codigo);
        
        if ($cupon) {
            $_SESSION['carrito']['cupon'] = $cupon;
            return $cupon;
        }
        
        return false;
    }
    
    public static function quitarCupon() {
        self::carrito();
        $_SESSION['carrito']['cupon'] = null;
        return true;
    }
    
    public static function obtenerCupon() {
        self::carrito();
        return $_SESSION['carrito']['cupon'] ?? null;
    }

    public static function obtenerCarrito() {
        self::carrito();
        $items = [];
        
        foreach ($_SESSION['carrito']['productos'] as $clave => $datosProducto) {
            $id = $datosProducto['id'];
            $cantidad = $datosProducto['cantidad'];
            $talla = $datosProducto['talla'] ?? null;
            
            $producto = Producto::find($id);
            if ($producto && $producto->activo == 1) {
                $precio = $producto->precio;
                
                // Si hay talla, buscar el precio específico para esa talla
                if ($talla) {
                    $condiciones = [
                        'productos_id' => $id,
                        'tallas_id' => $talla,
                        'activo' => 1
                    ];
                    $productoTalla = ProductoTalla::consultarSQL("SELECT * FROM productos_tallas WHERE productos_id =  {$condiciones['productos_id']} AND tallas_id = {$condiciones['tallas_id']} AND activo = {$condiciones['activo']}");
                    
                    if ($productoTalla && !empty($productoTalla) && $productoTalla[0]->precio !== null) {
                        $precio = $productoTalla[0]->precio;
                    }
                }
                
                // Obtener el nombre de la talla si existe
                $nombreTalla = null;
                if ($talla) {
                    $tallaObj = Talla::find($talla);
                    $nombreTalla = $tallaObj ? $tallaObj->nombre : null;
                }
                
                $items[] = [
                    'clave' => $clave,
                    'id' => $id,
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'subtotal' => $cantidad * $precio,
                    'talla' => $nombreTalla
                ];
            }
        }
        
        return $items;
    }

    public static function obtenerTotal() {
        $items = self::obtenerCarrito();
        $total = 0;
        
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }
        
        return $total;
    }
    
    public static function obtenerTotalConDescuento() {
        $total = self::obtenerTotal();
        $cupon = self::obtenerCupon();
        
        if ($cupon) {
            if ($cupon['tipo_descuento'] === 'porcentaje') {
                $descuento = ($total * $cupon['descuento']) / 100;
            } else { // tipo_descuento === 'monto'
                $descuento = $cupon['descuento'];
                // Asegurarse de que el descuento no sea mayor que el total
                if ($descuento > $total) {
                    $descuento = $total;
                }
            }
            return $total - $descuento;
        }
        
        return $total;
    }

    public static function obtenerCuentaCarrito() {
        self::carrito();
        return count($_SESSION['carrito']['productos']) > 0 ? count($_SESSION['carrito']['productos']) : 0;
    }
    public static function limpiarCarrito() {
        self::carrito();
        $_SESSION['carrito'] = [
            'productos' => [],
            'cupon' => null
        ];
        return true;
    }
}