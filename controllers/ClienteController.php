<?php


namespace Controllers;

use Model\Usuario;

use MVC\Router;

use Model\Rol;


class ClienteController
{

    public static function index(Router $router)
    {
        session_start();
        isAdmin();
        $usuarios = Usuario::all();
        $router->render('clientes/admin', [
            'usuarios' => $usuarios,
            'pageTitle' => 'clientes',
            'titulo' => 'admin'
        ]);
    }

    public static function actualizar(Router $router)
    {
        session_start();
        isAdmin();
        $id = validarORedireccionar('/customers/admin');
        $usuario = Usuario::find($id);
        $alertas = Usuario::getAlertas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar();
            if (empty($alertas['error'])) {
                $usuario->guardar();
                header('Location: /customers/admin');
            }
        }
        $router->render('/clientes/actualizar', [
            'usuario' => $usuario,
            'alertas' => $alertas,
            'roles' => Rol::all(),
            'pageTitle' => 'Actualizar cliente',
            'titulo' => 'admin'
        ]);
    }
}
