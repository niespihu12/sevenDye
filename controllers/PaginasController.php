<?php

namespace Controllers;

use Model\Influencer;
use Model\Testimonio;
use MVC\Router;
use PHPMailer\PHPMailer\PHPMailer;


class PaginasController{

    public static function index(Router $router){
        $testimonios = Testimonio::all();
        $influencers = Influencer::get(3);

        $router->render('paginas/index', [
            'testimonios' => $testimonios,
            'influencers' => $influencers
        ]);
    }

    public static function nosotros(Router $router){
        $router->render('paginas/nosotros');
    }

    public static function contacto(Router $router){
        $mensaje = null;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
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
            if($mail->send()){
                $mensaje = "Mensaje enviado correctamente";
            } else{
                $mensaje = "El mensaje no se pudo enviar..";
            }
        

        }

        $router->render('paginas/contacto',[
            'mensaje' => $mensaje
        ]);


    }
}