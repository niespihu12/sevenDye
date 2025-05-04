<?php

namespace Controllers;

use MVC\Router;
use Model\Producto;
use Model\ProductoImagen;
use Model\ProductoTalla;
use Model\Talla;
use Model\color;
use Model\Categoria;
use Model\ProductoColor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

class ProductoController
{
    public static function index(Router $router)
    {
        session_start();

        isAdmin();
        $productos = Producto::all();
        $imagenes = [];
        foreach ($productos as $producto) {
            $imagen = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id = {$producto->id} LIMIT 1");
            $imagenes[$producto->id] = $imagen[0]->imagen ?? '';
        }

        $router->render('productos/admin', [
            'productos' => $productos,
            'imagenes' => $imagenes,
            'pageTitle' => 'Productos'
        ]);
    }

    public static function crear(Router $router)
    {
        session_start();

        isAdmin();

        $producto = new Producto;
        $categorias = Categoria::all();
        $tallas = Talla::all();
        $colores = Color::all();
        $alertas = Producto::getAlertas();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto = new Producto($_POST);
            $alertas = $producto->validar();
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            $imagenesSubidas = [];

            // Validar imágenes
            if (count($_FILES['imagen']['tmp_name']) > 4) {
                $producto->setAlerta("error", "Solo se permiten 4 imagenes por producto");
            } else {
                if ($_FILES['imagen']['tmp_name'][0]) {
                    $manager = new Image(Driver::class);
                    foreach ($_FILES['imagen']['tmp_name'] as $imagen) {
                        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                        $image = $manager->read($imagen);
                        $image->save(CARPETA_IMAGENES . $nombreImagen);
                        $imagenesSubidas[] = $nombreImagen;
                    }
                } else {
                    $producto->setAlerta("error", "La imagen del producto es obligatoria");
                }
            }

            // Validar colores
            if (!isset($_POST['colores']) || empty($_POST['colores'])) {
                Producto::setAlerta('error', 'Debe seleccionar al menos un color');
            }

            // Validar tallas
            $tallaSeleccionada = false;
            if (isset($_POST['tallas_activas'])) {
                $tallaSeleccionada = true;
            }

            if (!$tallaSeleccionada) {
                Producto::setAlerta('error', 'Debe activar al menos una talla');
            }

            // Validar precios de tallas
            if (isset($_POST['talla_precios'])) {
                foreach ($_POST['talla_precios'] as $talla_id => $precio) {
                    if (isset($_POST['tallas_activas']) && in_array($talla_id, $_POST['tallas_activas']) && (empty($precio) || !is_numeric($precio))) {
                        Producto::setAlerta('error', 'Las tallas activas deben tener un precio válido');
                        break;
                    }
                }
            }

            $alertas = Producto::getAlertas();

            if (empty($alertas)) {
                $producto->crearReferencia();
                $producto->creado = date('Y/m/d');
                $resultado = $producto->guardar();
                $producto = Producto::where('referencia', $producto->referencia);

                if ($resultado) {
                    // Guardar imágenes
                    foreach ($imagenesSubidas as $imagen) {
                        $productosImagen = new ProductoImagen([
                            'imagen' => $imagen,
                            'productos_id' => $producto->id,
                            'creado' => date('Y/m/d')
                        ]);
                        $productosImagen->guardar();
                    }

                    // Guardar tallas
                    if (isset($_POST['tallas_activas'])) {
                        foreach ($_POST['tallas_activas'] as $talla_id) {
                            $precioTalla = $_POST['talla_precios'][$talla_id] ?? $producto->precio;

                            $productoTalla = new ProductoTalla([
                                'productos_id' => $producto->id,
                                'tallas_id' => $talla_id,
                                'precio' => $precioTalla,
                                'activo' => 1
                            ]);
                            $productoTalla->guardar();
                        }
                    }

                    // Guardar colores
                    foreach ($_POST['colores'] as $color_id) {
                        $productoColor = new ProductoColor([
                            'productos_id' => $producto->id,
                            'colores_id' => $color_id
                        ]);
                        $productoColor->guardar();
                    }

                    header('Location: /productos/admin');
                }
            }
        }

        $alertas = Producto::getAlertas();

        $router->render('productos/crear', [
            'producto' => $producto,
            'alertas' => $alertas,
            'categorias' => $categorias,
            'tallas' => $tallas,
            'colores' => $colores,
            'pageTitle' => 'Crear Producto',
            'coloresSeleccionados' => []
        ]);
    }

    public static function actualizar(Router $router)
    {
        session_start();

        isAdmin();
        $id = validarORedireccionar('/productos/admin');
        $producto = Producto::find($id);
        $alertas = Producto::getAlertas();
        $categorias = Categoria::all();
        $tallas = Talla::all();
        $colores = Color::all();

        $imagenes = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id = {$id}");
        $tallasActuales = ProductoTalla::consultarSQL("SELECT * FROM productos_tallas WHERE productos_id = {$id}");
        $coloresActuales = ProductoColor::consultarSQL("SELECT * FROM productos_colores WHERE productos_id = {$id}");

        // Preparar datos para el formulario
        $preciosTallas = [];
        $tallasActivas = [];

        foreach ($tallasActuales as $talla) {
            $preciosTallas[$talla->tallas_id] = $talla->precio;
            if ($talla->activo) {
                $tallasActivas[] = $talla->tallas_id;
            }
        }

        $coloresSeleccionados = array_map(function ($pc) {
            return $pc->colores_id;
        }, $coloresActuales);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = $_POST;
            $producto->sincronizar($args);
            $alertas = $producto->validar();

            // Validar imágenes
            $imagenesSubidas = [];
            if (!empty($_FILES['imagen']['tmp_name'][0])) {
                if (count($_FILES['imagen']['tmp_name']) > 4) {
                    $producto->setAlerta("error", "Solo se permiten 4 imágenes por producto");
                } else {
                    $manager = new Image(Driver::class);
                    foreach ($_FILES['imagen']['tmp_name'] as $imagenTmp) {
                        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                        $image = $manager->read($imagenTmp)->cover(1000, 1000);
                        $image->save(CARPETA_IMAGENES . $nombreImagen);
                        $imagenesSubidas[] = $nombreImagen;
                    }
                }
            }

            // Validar colores
            if (!isset($_POST['colores']) || empty($_POST['colores'])) {
                Producto::setAlerta('error', 'Debe seleccionar al menos un color');
            }

            // Validar tallas
            $tallaSeleccionada = false;
            if (isset($_POST['tallas_activas']) && !empty($_POST['tallas_activas'])) {
                $tallaSeleccionada = true;
            }

            if (!$tallaSeleccionada) {
                Producto::setAlerta('error', 'Debe activar al menos una talla');
            }

            // Validar precios de tallas
            if (isset($_POST['talla_precios']) && isset($_POST['tallas_activas'])) {
                foreach ($_POST['tallas_activas'] as $talla_id) {
                    $precio = $_POST['talla_precios'][$talla_id] ?? '';
                    if (empty($precio) || !is_numeric($precio)) {
                        Producto::setAlerta('error', 'Las tallas activas deben tener un precio válido');
                        break;
                    }
                }
            }

            if (empty($alertas)) {
                $producto->actualizado = date('Y/m/d');
                $resultado = $producto->guardar();

                if ($resultado) {
                    // Procesar imágenes a eliminar
                    if (!empty($_POST['eliminar_imagenes'])) {
                        foreach ($_POST['eliminar_imagenes'] as $idImagenEliminar) {
                            $imagenObj = ProductoImagen::find($idImagenEliminar);
                            if ($imagenObj && file_exists(CARPETA_IMAGENES . $imagenObj->imagen)) {
                                unlink(CARPETA_IMAGENES . $imagenObj->imagen);
                            }
                            $imagenObj?->eliminar();
                        }
                    }

                    // Guardar nuevas imágenes
                    foreach ($imagenesSubidas as $nombreImagen) {
                        $productoImagen = new ProductoImagen([
                            'imagen' => $nombreImagen,
                            'productos_id' => $producto->id,
                            'creado' => date('Y/m/d')
                        ]);
                        $productoImagen->guardar();
                    }

                    // Actualizar tallas
                    foreach ($tallasActuales as $tallaActual) {
                        $tallaActual->eliminar();
                    }

                    if (isset($_POST['tallas_activas'])) {
                        foreach ($_POST['tallas_activas'] as $talla_id) {
                            $precioTalla = $_POST['talla_precios'][$talla_id] ?? $producto->precio;

                            $productoTalla = new ProductoTalla([
                                'productos_id' => $producto->id,
                                'tallas_id' => $talla_id,
                                'precio' => $precioTalla,
                                'activo' => 1
                            ]);
                            $productoTalla->guardar();
                        }
                    }

                    // Para las tallas no activas pero con precio definido
                    if (isset($_POST['talla_precios'])) {
                        $tallasInactivas = array_diff(array_keys($_POST['talla_precios']), $_POST['tallas_activas'] ?? []);
                        foreach ($tallasInactivas as $talla_id) {
                            $precio = $_POST['talla_precios'][$talla_id] ?? '';
                            if (!empty($precio) && is_numeric($precio)) {
                                $productoTalla = new ProductoTalla([
                                    'productos_id' => $producto->id,
                                    'tallas_id' => $talla_id,
                                    'precio' => $precio,
                                    'activo' => 0
                                ]);
                                $productoTalla->guardar();
                            }
                        }
                    }

                    // Actualizar colores
                    foreach ($coloresActuales as $colorActual) {
                        $colorActual->eliminar();
                    }

                    foreach ($_POST['colores'] as $color_id) {
                        $productoColor = new ProductoColor([
                            'productos_id' => $producto->id,
                            'colores_id' => $color_id
                        ]);
                        $productoColor->guardar();
                    }

                    header('Location: /productos/admin');
                    exit;
                }
            }
        }

        $alertas = Producto::getAlertas();



        $router->render('productos/actualizar', [
            'producto' => $producto,
            'alertas' => $alertas,
            'categorias' => $categorias,
            'tallas' => $tallas,
            'colores' => $colores,
            'imagenes' => $imagenes,
            'preciosTallas' => $preciosTallas,
            'tallasActivas' => $tallasActivas,
            'coloresSeleccionados' => $coloresSeleccionados,
            'pageTitle' => 'Editar Producto'
        ]);
    }

    public static function eliminar(Router $router)
    {
        session_start();

        isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar ID
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $producto = Producto::find($id);

                if ($producto) {
                    // Eliminar imágenes
                    $query = "SELECT * FROM producto_imagen WHERE productos_id = {$id}";
                    $imagenes = ProductoImagen::consultarSQL($query);
                    foreach ($imagenes as $imagen) {
                        $imagen->borrarImagen();
                        $imagen->eliminar();
                    }

                    // Eliminar tallas
                    $query = "SELECT * FROM productos_tallas WHERE productos_id = {$id}";
                    $tallas = ProductoTalla::consultarSQL($query);
                    foreach ($tallas as $talla) {
                        $talla->eliminar();
                    }

                    // Eliminar colores
                    $query = "SELECT * FROM productos_colores WHERE productos_id = {$id}";
                    $colores = ProductoColor::consultarSQL($query);
                    foreach ($colores as $color) {
                        $color->eliminar();
                    }

                    // Eliminar producto
                    $resultado = $producto->eliminar();

                    if ($resultado) {
                        header('Location: /productos/admin');
                    }
                }
            }
        }
    }

    public static function buscar()
    {
        header('Content-Type: application/json');

        if (!isset($_GET['q']) || empty($_GET['q'])) {
            echo json_encode([]);
            exit;
        }

        $searchTerm = $_GET['q'];

        $query = "SELECT * FROM productos WHERE 
                    nombre LIKE '%{$searchTerm}%' OR 
                    referencia LIKE '%{$searchTerm}%' OR 
                    descripcion LIKE '%{$searchTerm}%' 
                    LIMIT 6";

        $productos = Producto::consultarSQL($query);
        $resultados = [];

        foreach ($productos as $producto) {
            $imagenQuery = "SELECT * FROM producto_imagen WHERE productos_id = {$producto->id} LIMIT 1";
            $imagenes = ProductoImagen::consultarSQL($imagenQuery);

            $resultados[] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'slug' => $producto->slug,
                'referencia' => $producto->referencia,
                'imagen' => $imagenes[0]->imagen ?? null
            ];
        }

        echo json_encode($resultados);
        exit;
    }
}
