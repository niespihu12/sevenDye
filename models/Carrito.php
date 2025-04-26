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

    public static function añadirproducto($id, $cantidad)
    {
        self::carrito();

        if (isset($_SESSION['carrito']['productos'][$id])) {
            $_SESSION['carrito']['productos'][$id] += $cantidad;
        } else {
            $_SESSION['carrito']['productos'][$id] = $cantidad;
        }


        return count($_SESSION['carrito']['productos']);
    }

    public static function actualizarproducto($productoId, $cantidad)
    {
        self::carrito();

        if ($productoId > 0 && $cantidad > 0 && is_numeric($cantidad)) {
            if (isset($_SESSION['carrito']['productos'][$productoId])) {
                $_SESSION['carrito']['productos'][$productoId] = $cantidad;


                $producto = Producto::find($productoId);
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

    public static function eliminarProducto($productoId)
    {
        self::carrito();

        if ($productoId > 0) {
            if (isset($_SESSION['carrito']['productos'][$productoId])) {
                unset($_SESSION['carrito']['productos'][$productoId]);
                return true;
            }
        }

        return false;
    }

    public static function obtenerCarrito()
    {
        self::carrito();
        $items = [];

        foreach ($_SESSION['carrito']['productos'] as $id => $cantidad) {
            $producto = Producto::find($id);
            if ($producto && $producto->activo == 1) {
                $precio = $producto->precio;
                $descuento = $producto->precio_descuento;
                $precio_final = $descuento > 0 ? $descuento : $precio;

                $items[] = [
                    'id' => $id,
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'precio' => $precio_final,
                    'subtotal' => $cantidad * $precio_final
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
