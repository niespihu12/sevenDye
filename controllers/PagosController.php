<?php 


namespace Controllers;
use Model\Pagos;
use MVC\Router;


class PagosController{
    public static function index(Router $router){
        session_start();

        isAdmin();

        $pagos = Pagos::all();

        $router->render('pagos/index',[
            'pagos' => $pagos
        ]);


    }
}