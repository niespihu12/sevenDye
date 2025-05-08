<?php

namespace Controllers;

use MVC\Router;
use Model\Producto;
use Model\ProductoImagen;
use Model\Categoria;
use Model\Color;
use Model\ProductoColor;
use Model\ProductoTalla;
use Model\Subcategoria;
use Model\Talla;

class TiendaController
{
    public static function index(Router $router)
    {
        $db = conectarDB();
        $rangos = $db->query("SELECT min(precio) as min_precio, max(precio) as max_precio FROM productos WHERE activo = 1")->fetch_assoc();
        $min_db = floatval($rangos['min_precio'] ?? 0);
        $max_db = floatval($rangos['max_precio'] ?? 100);
        if ($min_db >= $max_db) {
            $max_db = $min_db + 1;
        }

        $filtro_precio_activo = isset($_GET['filtro_precio']) && $_GET['filtro_precio'] === '1';

        $precio_min = isset($_GET['precio_min']) ? floatval($_GET['precio_min']) : $min_db;
        $precio_max = isset($_GET['precio_max']) ? floatval($_GET['precio_max']) : $max_db;
        $precio_min = max($min_db, $precio_min);
        $precio_max = min($max_db, max($precio_min + 0.01, $precio_max));
        
        $color_id = isset($_GET['color']) ? (int)$_GET['color'] : 0;

        $query = "SELECT DISTINCT p.* FROM productos p WHERE p.activo = 1";

        if ($filtro_precio_activo) {
            $query .= " AND p.precio BETWEEN {$precio_min} AND {$precio_max}";
        }

        if ($color_id > 0) {
            $query .= " AND p.id IN (SELECT productos_id FROM productos_colores WHERE colores_id = {$color_id})";
        }

        if (isset($_GET['orden'])) {
            $orden = $_GET['orden'];
            if ($orden === 'precio_asc') {
                $query .= " ORDER BY p.precio ASC";
            } elseif ($orden === 'precio_desc') {
                $query .= " ORDER BY p.precio DESC";
            } else{
                $query .= "";
            }
        }

        $productos = Producto::consultarSQL($query);
        $categorias = Categoria::all();
        $colores = Color::all();

        $productosTotales = count(Producto::all());

        $imagenes = [];
        foreach ($productos as $producto) {
            $imagen = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id = {$producto->id} LIMIT 1");
            if (!empty($imagen)) {
                $imagenes[$producto->id] = $imagen[0]->imagen;
            }
        }

        $contadorProductos = [];
        foreach($categorias as $categoria) {
            $productosCategoria = Producto::consultarSQL("SELECT * FROM productos WHERE categorias_id = {$categoria->id}");
            $contadorProductos[$categoria->id] = count($productosCategoria);

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
            'filtro_precio_activo' => $filtro_precio_activo,
            'orden' => $_GET['orden'] ?? '',
            'contadorProductos' => $contadorProductos,
            'productosTotales' => $productosTotales
        ]);
    }

    public static function indexSlug(Router $router, $slug)
    {
        $categoria = Categoria::where('slug', $slug);
        
        if (!$categoria) {
            header('Location: /tienda');
            return;
        }
        $subcategorias = Subcategoria::porCategoria($categoria->id);
        $subcategoria_id = isset($_GET['subcategoria']) ? (int)$_GET['subcategoria'] : 0;

        
        $db = conectarDB();
        $rangos = $db->query("SELECT min(precio) as min_precio, max(precio) as max_precio FROM productos WHERE categorias_id = {$categoria->id} AND activo = 1")->fetch_assoc();
        $min_db = floatval($rangos['min_precio'] ?? 0);
        $max_db = floatval($rangos['max_precio'] ?? 100);
        if ($min_db >= $max_db) {
            $max_db = $min_db + 1;
        }

        $filtro_precio_activo = isset($_GET['filtro_precio']) && $_GET['filtro_precio'] === '1';

        $precio_min = isset($_GET['precio_min']) ? floatval($_GET['precio_min']) : $min_db;
        $precio_max = isset($_GET['precio_max']) ? floatval($_GET['precio_max']) : $max_db;
        $precio_min = max($min_db, $precio_min);
        $precio_max = min($max_db, max($precio_min + 0.01, $precio_max));
        
        $color_id = isset($_GET['color']) ? (int)$_GET['color'] : 0;

        $query = "SELECT DISTINCT p.* FROM productos p WHERE p.activo = 1 AND p.categorias_id = {$categoria->id}";

        if($subcategoria_id > 0) {
            $query .= " AND p.subcategorias_id = {$subcategoria_id}";
        }

        if ($filtro_precio_activo) {
            $query .= " AND p.precio BETWEEN {$precio_min} AND {$precio_max}";
        }

        if ($color_id > 0) {
            $query .= " AND p.id IN (SELECT productos_id FROM productos_colores WHERE colores_id = {$color_id})";
        }
        if (isset($_GET['orden'])) {
            $orden = $_GET['orden'];
            if ($orden === 'precio_asc') {
                $query .= " ORDER BY p.precio ASC";
            } elseif ($orden === 'precio_desc') {
                $query .= " ORDER BY p.precio DESC";
            } else{
                $query .= "";
            }
        }

        $productos = Producto::consultarSQL($query);
        $categorias = Categoria::all();
        $colores = Color::all();

        $productosTotales = count(Producto::all());

        $imagenes = [];
        foreach ($productos as $producto) {
            $imagen = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id = {$producto->id} LIMIT 1");
            if (!empty($imagen)) {
                $imagenes[$producto->id] = $imagen[0]->imagen;
            }
        }
        $contadorProductos = [];
        foreach($categorias as $categoria) {
            $productosCategoria = Producto::consultarSQL("SELECT * FROM productos WHERE categorias_id = {$categoria->id}");
            $contadorProductos[$categoria->id] = count($productosCategoria);

        }
        $contadorSubcategorias = [];
        foreach($subcategorias as $subcategoria) {
            $productosSubcategoria = Producto::consultarSQL("SELECT * FROM productos WHERE subcategorias_id = {$subcategoria->id}");
            $contadorSubcategorias[$subcategoria->id] = count($productosSubcategoria);
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
            'filtro_precio_activo' => $filtro_precio_activo,
            'orden' => $_GET['orden'] ?? '',
            'contadorProductos' => $contadorProductos,
            'productosTotales' => $productosTotales,
            'subcategorias' => $subcategorias,
            'contadorSubcategorias' => $contadorSubcategorias
        ]);
    }
    
    public static function detalles(Router $router, $slug)
    {
        $slug = isset($slug) ? $slug : '';
       
        $token = isset($_GET['token']) ? $_GET['token'] : '';

        if ($slug == '' || $token == '') {
            header('Location: /tienda');
            return;
        }
        
        $token_tmp = hash_hmac('sha1', $slug, KEY_TOKEN);
        if ($token_tmp != $token) {
            header('Location: /tienda');
            return;
        }

        $producto = Producto::where('slug', $slug);
        
        if (!$producto) {
            header('Location: /tienda');
            return;
        }
        
        $productoImagenes = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id = {$producto->id}");
        $productoImagenPrincipal = ProductoImagen::where('productos_id', $producto->id);
        $productoTallas = ProductoTalla::consultarSQL("SELECT * FROM productos_tallas  WHERE productos_id = {$producto->id}");
        $tallas = Talla::all();

        $productosCategorias = Producto::consultarSQL("SELECT * FROM productos WHERE categorias_id = {$producto->categorias_id} AND activo = 1 LIMIT 4");

        $imagenes = [];

        foreach($productosCategorias as $productoNew) {
            $imagenNew = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id={$productoNew->id} LIMIT 1");
            $imagenes[$productoNew->id] = $imagenNew[0]->imagen;

        }
        $router->render('tienda/detalles', [
            'producto' => $producto,
            'productoImagenes' => $productoImagenes,
            'productoTallas' => $productoTallas,
            'tallas' => $tallas,
            'productoImagenPrincipal' => $productoImagenPrincipal,
            'productoCategorias' => $productosCategorias,
            'imagenes' => $imagenes
        ]);
    }
    
    public static function checkout(Router $router)
    {
        $router->render('tienda/checkout', []);
    }
}