<?php


namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router){
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);

                if($usuario){
                    if($usuario->comprobarPasswordAndVerificado($auth->contraseña)){
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        if($usuario->rolId === "2"){
                            $_SESSION['rolId'] = $usuario->rolId ?? null;
                            header('Location: /admin');

                        }else{
                            header('Location: /');
                        }



                    }
                }else{
                    Usuario::setAlerta( 'error','Usuario no encontrado');
                }
            }

        }
        
        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas,
            'titulo' => 'login'
        ]);
    }

    public static function olvide(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)) {
                 $usuario = Usuario::where('email', $auth->email);

                 if($usuario && $usuario->confirmado === "1") {
                        
                    $usuario->crearToken();
                    $usuario->guardar();

                    $email = new Email($usuario->email,  $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito','Revisa tu email');
                 } else {
                     Usuario::setAlerta('error','El Usuario no existe o no esta confirmado');
                     
                 }
            } 
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas,
            'titulo' => 'forgot'
        ]);
    }

    public static function recuperar(Router $router) {
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        // Buscar usuario por su token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error','Token No Válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el nuevo password y guardarlo

            $contraseña = new Usuario($_POST);
            $alertas = $contraseña->validarPassword();

            if(empty($alertas)) {
                $usuario->contraseña = null;

                $usuario->contraseña = $contraseña->contraseña;
                $usuario->hashPassword();
                $usuario->token = null;
                $usuario->actualizado = date('Y/m/d');
                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas, 
            'error' => $error,
            'titulo' => 'recover'
        ]);
    }


    public static function registro(Router $router){
        $usuario = new Usuario();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $contraseña_repetida = $_POST['contraseña_repetida'];
            $alertas = $usuario->validarRegistro($contraseña_repetida);

            if(empty($alertas)){
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    $usuario->hashPassword();
                    $usuario->crearReferencia();
                    $usuario->crearToken();

                    $email = new Email($usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    $resultado = $usuario->guardar();

                    if($resultado){
                        header('Location: /message');
                    }
                }
            }

        }

        $router ->render('auth/register',[
            'usuario' => $usuario,
            'alertas' => $alertas,
            'titulo' => 'register'
        ]);

    }

    public static function confirmar(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error','Token No Válido');
        } else {
            $usuario->confirmado = "1";
            $usuario->token = '';
            $usuario->creado = date('Y/m/d');
            $usuario->guardar();
            Usuario::setAlerta('exito','Cuenta Comprobada Correctamente');
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas,
            'titulo' => 'confirm'
        ]);
    }

    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje', [
            'titulo' => 'message'
        ]);
    }
}