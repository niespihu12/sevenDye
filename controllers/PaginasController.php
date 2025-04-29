<?php

namespace Controllers;

use Model\Categoria;
use Model\Influencer;
use Model\Testimonio;
use MVC\Router;
use Model\Producto;
use Model\ProductoImagen;
use PHPMailer\PHPMailer\PHPMailer;


class PaginasController
{

    public static function index(Router $router)
    {
        $testimonios = Testimonio::all();
        $influencers = Influencer::get(3);
        $categorias = Categoria::all();

        $categoriasImportantes = Categoria::consultarSQL("SELECT * FROM categorias WHERE importante = '1' LIMIT 5");

        $query = "SELECT * FROM productos WHERE destacado = '1' LIMIT 8";
        $productos = Producto::consultarSQL($query);
        $imagenes = [];
        foreach($productos as $producto){
            $imagen = ProductoImagen::consultarSQL("SELECT * FROM producto_imagen WHERE productos_id = {$producto->id} LIMIT 1");
            $imagenes[$producto->id] = $imagen[0]->imagen;

            
        }

        var_dump($imagenes);

        $router->render('paginas/index', [
            'testimonios' => $testimonios,
            'influencers' => $influencers,
            'productos' => $productos,
            'categorias' => $categorias,
            'categoriasImportantes' => $categoriasImportantes
        ]);
    }

    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
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
