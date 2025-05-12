<?php 

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Model\Pagos;


class DashboardController{
    public static function index(Router $router){
        session_start();
        isAdmin();

        $usuarios = Usuario::all();
        $usuarios = count($usuarios);

        $pagosTotal = Pagos::ejecutarSQL("SELECT SUM(monto) FROM pagos")->fetch_assoc();
        $pagos= Pagos::consultarSQL("SELECT * FROM pagos LIMIT 5");

        $router->render('dashboard/dashboard',[
            'titulo' => 'admin',
            'usuarios' => $usuarios,
            'pagosTotal' => $pagosTotal,
            'pagos' => $pagos
        ]);
    }
}