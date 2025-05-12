<?php 


namespace Controllers;

use Model\ArticuloOrden;
use Model\BillingDetail;
use Model\Orden;
use MVC\Router;


class OrdenController{
    public static function index(Router $router){
        $ordenes = Orden::all();
        $router->render('orden/admin', [
            'ordenes' => $ordenes,
            'titulo' => 'admin',
            'pageTitle' => 'Ordenes'
        ]);
    }

    public static function see(Router $router){
        $id = validarORedireccionar('/orders/admin');

        $billing_details = BillingDetail::where('ordenes_id', $id);
        $articulos_pedidos = ArticuloOrden::consultarSQL("SELECT * FROM articulos_pedidos WHERE ordenes_id = {$id}");
        $router->render('orden/see', [
            'billing_details' => $billing_details,
            'articulos_pedidos' => $articulos_pedidos,
            'titulo' => 'admin',
            'pageTitle' => 'Orden'
        ]);
    
    }
}