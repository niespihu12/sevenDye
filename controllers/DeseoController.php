<?php

namespace Controllers;

use Model\ListaDeseo;
use Model\Producto;
use Model\ProductoImagen;

use MVC\Router;

class DeseoController
{
    public static function index(Router $router)
    {
        session_start();

        if (!isset($_SESSION['id'])) {
            header('Location: /login');
            return;
        }

        $usuario_id = $_SESSION['id'];
        $consulta = "SELECT p.* FROM productos p ";
        $consulta .= "INNER JOIN lista_deseos ld ON ld.productos_id = p.id ";
        $consulta .= "WHERE ld.usuarios_id = " . $usuario_id;

        $productos = Producto::consultarSQL($consulta);
        $idsProductos = [];
        foreach ($productos as $producto) {
            $idsProductos[] = $producto->id;
        }

        if (!empty($idsProductos)) {
            $idsString = implode(",", $idsProductos);
            $consultaImagenes = "SELECT * FROM producto_imagen WHERE productos_id IN ($idsString)";
            $imagenes = ProductoImagen::consultarSQL($consultaImagenes);
        } else {
            $imagenes = [];
        }
        $router->render('usuario/listaDeseos', [
            'titulo' => 'My Wishlist',
            'productos' => $productos,
            'imagenes' => $imagenes
        ]);
    }
    public static function guardar()
    {
        session_start();

        if (!isset($_SESSION['id'])) {
            echo json_encode(['resultado' => false, 'mensaje' => 'Usuario no autenticado']);
            return;
        }
        $json = file_get_contents('php://input');
        $datos = json_decode($json, true);
        if (!isset($datos['producto'])) {
            echo json_encode(['resultado' => false, 'mensaje' => 'Producto no válido']);
            return;
        }

        $producto = $datos['producto'];
        $consulta = "SELECT * FROM lista_deseos WHERE usuarios_id = " . $_SESSION['id'];
        $consulta .= " AND productos_id = " . $producto;

        $existe = ListaDeseo::consultarSQL($consulta);

        if (!empty($existe)) {
            echo json_encode(['resultado' => false, 'mensaje' => 'El producto ya está en tu lista de deseos']);
            return;
        }

        $fecha_actual = date('Y-m-d H:i:s');

        $args = [
            'usuarios_id' => $_SESSION['id'],
            'productos_id' => $producto,
            'creado' => $fecha_actual,
            'actualizado' => $fecha_actual
        ];

        $listaDeseos = new ListaDeseo($args);
        $resultado = $listaDeseos->guardar();

        $respuesta = [
            'resultado' => $resultado,
            'mensaje' => $resultado ? 'Producto agregado a tu lista de deseos' : 'Error al agregar el producto'
        ];

        echo json_encode($respuesta);
    }
    public static function eliminar()
    {
        session_start();

        if (!isset($_SESSION['id'])) {
            echo json_encode(['resultado' => false, 'mensaje' => 'Usuario no autenticado']);
            return;
        }
        $json = file_get_contents('php://input');
        $datos = json_decode($json, true);
        if (!isset($datos['producto'])) {
            echo json_encode(['resultado' => false, 'mensaje' => 'Producto no válido']);
            return;
        }
        $producto_id = $datos['producto'];
        $usuario_id = $_SESSION['id'];
        $consulta = "SELECT id FROM lista_deseos WHERE usuarios_id = " . $usuario_id;
        $consulta .= " AND productos_id = " . $producto_id . " LIMIT 1";

        $registros = ListaDeseo::consultarSQL($consulta);

        if (empty($registros)) {
            echo json_encode(['resultado' => false, 'mensaje' => 'El producto no está en tu lista de deseos']);
            return;
        }

        $deseo = $registros[0];
        $resultado = $deseo->eliminar();

        $respuesta = [
            'resultado' => $resultado,
            'mensaje' => $resultado ? 'Producto eliminado de tu lista de deseos' : 'Error al eliminar el producto'
        ];

        echo json_encode($respuesta);
    }
    public static function contarDeseos()
    {
        session_start();

        if (!isset($_SESSION['id'])) {
            echo json_encode(['count' => 0]);
            return;
        }

        $usuario_id = $_SESSION['id'];
        $consulta = "SELECT COUNT(*) as total FROM lista_deseos WHERE usuarios_id = " . $usuario_id;
        $resultado = ListaDeseo::ejecutarSQL($consulta);
        $resultado = $resultado->fetch_all(MYSQLI_ASSOC);
        $total = $resultado[0]['total'] ?? 0;

        echo json_encode(['count' => (int)$total]);
    }
    public static function verificar()
    {
        session_start();

        if (!isset($_SESSION['id']) || !isset($_GET['producto'])) {
            echo json_encode(['enLista' => false]);
            return;
        }

        $producto_id = $_GET['producto'];
        $usuario_id = $_SESSION['id'];

        $consulta = "SELECT id FROM lista_deseos WHERE usuarios_id = " . $usuario_id;
        $consulta .= " AND productos_id = " . $producto_id;

        $existe = ListaDeseo::consultarSQL($consulta);

        echo json_encode([
            'enLista' => !empty($existe)
        ]);
    }
}
