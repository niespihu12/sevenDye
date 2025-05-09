<?php 

namespace Controllers;

use MVC\Router;

class DashboardController{
    public static function index(Router $router){
        session_start();
        isAdmin();
        $router->render('dashboard/dashboard',[
            'titulo' => 'admin'
        ]);
    }
}