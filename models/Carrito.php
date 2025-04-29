<?php
namespace Model;

class Carrito
{
    public static function carrito()
    {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [
                'productos' => []
            ];
        }
    }

    public static function añadirproducto($id, $cantidad, $talla = null)
    {
        self::carrito();
        
        // Crear una clave única para cada combinación de producto y talla
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

    public static function actualizarproducto($clave, $cantidad)
    {
        self::carrito();

        if ($cantidad > 0 && is_numeric($cantidad)) {
            if (isset($_SESSION['carrito']['productos'][$clave])) {
                $datosProducto = $_SESSION['carrito']['productos'][$clave];
                $id = $datosProducto['id'];
                $_SESSION['carrito']['productos'][$clave]['cantidad'] = $cantidad;

                $producto = Producto::find($id);
                if ($producto && $producto->activo == 1) {
                    $precio = $producto->precio;
                    $descuento = $producto->precio_descuento;
                    $precio_final = $descuento > 0 ? $descuento : $precio;

                    return $cantidad * $precio_final;
                }
            }
        }

        return 0;
    }

    public static function eliminarProducto($clave)
    {
        self::carrito();

        if (isset($_SESSION['carrito']['productos'][$clave])) {
            unset($_SESSION['carrito']['productos'][$clave]);
            return true;
        }

        return false;
    }

    public static function obtenerCarrito()
    {
        self::carrito();
        $items = [];

        foreach ($_SESSION['carrito']['productos'] as $clave => $datosProducto) {
            $id = $datosProducto['id'];
            $cantidad = $datosProducto['cantidad'];
            $talla = $datosProducto['talla'] ?? null;
            
            $producto = Producto::find($id);
            if ($producto && $producto->activo == 1) {
                $precio = $producto->precio;
                $descuento = $producto->precio_descuento;
                $precio_final = $descuento > 0 ? $descuento : $precio;

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
                    'precio' => $precio_final,
                    'subtotal' => $cantidad * $precio_final,
                    'talla' => $nombreTalla
                ];
            }
        }

        return $items;
    }

    public static function obtenerTotal(){
        $items = self::obtenerCarrito();
        $total = 0;

        foreach ($items as $item) {
            $total += $item['subtotal'];
        }

        return $total;
    }

    public static function obtenerCuentaCarrito(){
        self::carrito();
        return count($_SESSION['carrito']['productos']) > 0 ? count($_SESSION['carrito']['productos']) : [];
    }
}