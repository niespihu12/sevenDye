<?php

namespace Controllers;

use MVC\Router;
use Model\Producto;
use Model\ProductoImagen;
use Model\Categoria;
use Model\Color;
use Model\ProductoColor;
use Model\ProductoTalla;
use Model\Talla;

class TiendaController
{
    public static function index(Router $router)
    {
        $db = conectarDB();
        $rangos = $db->query("SELECT min(precio) as min_precio, max(precio) as max_precio FROM productos")->fetch_assoc();
        $min_db = $rangos['min_precio'] ?? 0;
        $max_db = $rangos['max_precio'] ?? 100;

        $filtro_precio_activo = isset($_GET['filtro_precio']) && $_GET['filtro_precio'] === '1';

        $precio_min = isset($_GET['precio_min']) ? (float)$_GET['precio_min'] : $min_db;
        $precio_max = isset($_GET['precio_max']) ? (float)$_GET['precio_max'] : $max_db;
        $color_id = isset($_GET['color']) ? (int)$_GET['color'] : 0;

        $query = "SELECT DISTINCT p.* FROM productos p WHERE p.activo = 1";

        if ($filtro_precio_activo) {
            $query .= " AND p.precio BETWEEN {$precio_min} AND {$precio_max}";
        }

        if ($color_id > 0) {
            $query .= " AND p.id IN (SELECT productos_id FROM productos_colores WHERE colores_id = {$color_id})";
        }

        $productos = Producto::consultarSQL($query);
        $categorias = Categoria::all();
        $colores = Color::all();

        $imagenes = [];
        foreach ($productos as $producto) {
            $imagen = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id = {$producto->id} LIMIT 1");
            if (!empty($imagen)) {
                $imagenes[$producto->id] = $imagen[0]->imagen;
            }
        }

        $router->render('tienda/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'colores' => $colores,
            'imagenes' => $imagenes,
            'precio_min' => $precio_min,
            'precio_max' => $precio_max,
            'min_db' => $min_db,
            'max_db' => $max_db,
            'color_id' => $color_id,
            'filtro_precio_activo' => $filtro_precio_activo
        ]);
    }

    public static function indexSlug(Router $router, $slug)
    {
        $db = conectarDB();
        $rangos = $db->query("SELECT min(precio) as min_precio, max(precio) as max_precio FROM productos")->fetch_assoc();
        $min_db = $rangos['min_precio'] ?? 0;
        $max_db = $rangos['max_precio'] ?? 100;

        $filtro_precio_activo = isset($_GET['filtro_precio']) && $_GET['filtro_precio'] === '1';

        $precio_min = isset($_GET['precio_min']) ? (float)$_GET['precio_min'] : $min_db;
        $precio_max = isset($_GET['precio_max']) ? (float)$_GET['precio_max'] : $max_db;
        $color_id = isset($_GET['color']) ? (int)$_GET['color'] : 0;

        $categorias = Categoria::all();
        $colores = Color::all();

        if ($slug) {
            $categoria = Categoria::where('slug', $slug);

            $query = "SELECT DISTINCT p.* FROM productos p WHERE p.activo = 1 AND p.categorias_id = {$categoria->id}";

            if ($filtro_precio_activo) {
                $query .= " AND p.precio BETWEEN {$precio_min} AND {$precio_max}";
            }

            if ($color_id > 0) {
                $query .= " AND p.id IN (SELECT productos_id FROM productos_colores WHERE colores_id = {$color_id})";
            }

            $productos = Producto::consultarSQL($query);
        } else {
            $query = "SELECT DISTINCT p.* FROM productos p WHERE p.activo = 1";

            if ($filtro_precio_activo) {
                $query .= " AND p.precio BETWEEN {$precio_min} AND {$precio_max}";
            }

            if ($color_id > 0) {
                $query .= " AND p.id IN (SELECT productos_id FROM productos_colores WHERE colores_id = {$color_id})";
            }

            $productos = Producto::consultarSQL($query);
        }

        $imagenes = [];
        foreach ($productos as $producto) {
            $imagen = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id = {$producto->id} LIMIT 1");
            if (!empty($imagen)) {
                $imagenes[$producto->id] = $imagen[0]->imagen;
            }
        }

        $router->render('tienda/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'colores' => $colores,
            'imagenes' => $imagenes,
            'precio_min' => $precio_min,
            'precio_max' => $precio_max,
            'min_db' => $min_db,
            'max_db' => $max_db,
            'color_id' => $color_id,
            'categoria_slug' => $slug,
            'filtro_precio_activo' => $filtro_precio_activo
        ]);
    }
    public static function detalles(Router $router, $slug)
    {

        $slug = isset($slug) ? $slug : '';
        $token = isset($_GET['token']) ? $_GET['token'] : '';

        $producto = Producto::where('slug', $slug);
        $productoImagenes = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id = {$producto->id}");
        $productoImagenPrincipal = ProductoImagen::where('productos_id', $producto->id);
        $productoTallas = ProductoTalla::consultarSQL("SELECT * FROM productos_tallas  WHERE productos_id = {$producto->id} AND cantidad != 0 ");
        $tallas = Talla::all();





        if ($slug == '' || $token == '') {
            header('Location: /tienda');
        } else {
            $token_tmp = hash_hmac('sha1', $slug, KEY_TOKEN);
            if ($token_tmp != $token) {
                header('Location: /tienda');
            }
        }


        $router->render('tienda/detalles', [
            'producto' => $producto,
            'productoImagenes' => $productoImagenes,
            'productoTallas' => $productoTallas,
            'tallas' => $tallas,
            'productoImagenPrincipal' => $productoImagenPrincipal
        ]);
    }
    public static function checkout(Router $router)
    {
        $router->render('tienda/checkout', []);
        
    }
}
