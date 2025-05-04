<?php

namespace Controllers;

use Model\Categoria;
use Model\Influencer;
use Model\Testimonio;
use MVC\Router;
use Model\Producto;
use Model\ProductoImagen;
use Model\Blog;
use Model\BlogCategoria;
use PHPMailer\PHPMailer\PHPMailer;


class PaginasController
{

    public static function index(Router $router)
    {
        $testimonios = Testimonio::all();
        $influencers = Influencer::get(3);
        $categoriasCompletas = Categoria::all();

        $query = "SELECT * FROM categorias WHERE importante = '1'";
        $categorias = Categoria::consultarSQL($query);

        $query = "SELECT * FROM productos WHERE destacado = '1' LIMIT 8";
        $productos = Producto::consultarSQL($query);

        $productosPorCategoria = [];
        foreach ($categorias as $categoria) {
            $query = "SELECT * FROM productos WHERE categorias_id = {$categoria->id} ORDER BY id DESC LIMIT 4";
            $productosPorCategoria[$categoria->id] = Producto::consultarSQL($query);
        }

        $imagenes = [];
        // Corregido: iterar sobre cada grupo de productos por categoría
        foreach ($productosPorCategoria as $catId => $productosCategoria) {
            foreach ($productosCategoria as $producto) {
                $query = "SELECT * FROM producto_imagen WHERE productos_id = {$producto->id} LIMIT 1";
                $resultado = ProductoImagen::consultarSQL($query);

                if (!empty($resultado)) {
                    $imagenes[$producto->id] = $resultado[0]->imagen;
                } else {
                    $imagenes[$producto->id] = 'imagen_default.jpg'; // Imagen por defecto si no hay resultados
                }
            }
        }

        $router->render('paginas/index', [
            'testimonios' => $testimonios,
            'influencers' => $influencers,
            'productos' => $productos,
            'categorias' => $categorias,
            'productosPorCategoria' => $productosPorCategoria,
            'imagenes' => $imagenes,
            'categoriasCompletas' => $categoriasCompletas
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }


    public static function blog(Router $router)
    {
        $blogLatest = Blog::consultarSQL("SELECT * FROM blog ORDER BY id DESC LIMIT 3");
        $blogUnico = Blog::consultarSQL("SELECT * FROM blog ORDER BY id DESC LIMIT 1");
        $router->render('blogs/index', [
            'blogLatest' => $blogLatest,
            'blogUnico' => $blogUnico[0]
        ]);
    }

    public static function blogDetalle(Router $router, $slug)
    {
        $slug = isset($slug) ? $slug : '';
        $token = isset($_GET['token']) ? $_GET['token'] : '';

        if ($slug == '' || $token == '') {
            header('Location: /blog');
            return;
        }

        $token_tmp = hash_hmac('sha1', $slug, KEY_TOKEN);
        if ($token_tmp != $token) {
            header('Location: /blog');
            return;
        }

        $blog = Blog::where('slug', $slug);

        if (!$blog) {
            header('Location: /blog');
            return;
        }

        $publicaciones = Blog::consultarSQL("SELECT * FROM blog ORDER BY id DESC LIMIT 5");

        $router->render('blogs/entrada', [
            'blog' => $blog,
            'publicaciones' => $publicaciones
        ]);
    }
    public static function blogCategoria(Router $router, $slug)
    {
        $slug = isset($slug) ? $slug : '';

        if ($slug == '') {
            header('Location: /blog');
            return;
        }
        $blog = BlogCategoria::where('slug', $slug);

        if (!$blog) {
            header('Location: /blog');
            return;
        }

        $blogs = Blog::consultarSQL("SELECT * FROM blog WHERE blog_categorias_id = {$blog->id} ORDER BY id DESC");

        $publicaciones = Blog::consultarSQL("SELECT * FROM blog ORDER BY id DESC LIMIT 5");

        $router->render('blogs/categoria', [
            'blogs' => $blogs,
            'publicaciones' => $publicaciones
        ]);
    }

    public static function contacto(Router $router)
    {
        $mensaje = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestas = $_POST['contacto'];

            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '82743787ce19fe';
            $mail->Password = '6ba657381f8fef';
            $mail->SMTPSecure = 'tls';

            $mail->setFrom('admin@sevendye.com');
            $mail->addAddress('admin@sevendye.com', 'sevendye.com');
            $mail->Subject = "Tienes un Nuevo Mensaje";


            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . ' </p>';
            $contenido .= '<p>Email: ' . $respuestas['email'] . ' </p>';
            $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . ' </p>';
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . ' </p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = "Esto es texto alternativo sin HTML";

            //  Enviar el email
            if ($mail->send()) {
                $mensaje = "Mensaje enviado correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar..";
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}
